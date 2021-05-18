<?php

namespace App\Controllers;
use App\Models\MunicipioModel;
use App\Models\{ContactoModel, TelefonoModel, CorreoModel};
use  App\Libraries\Usuario\Perfil as CPerfil;
use  App\Libraries\Usuario;

class Perfil extends BaseController
{   
    protected $usuario;     
    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();              
    }

    public function obtenerCorreoYTelefono()
    {
        $contactoModel = new ContactoModel();
		$info = $contactoModel->find($this->usuario->getId());
        echo json_encode([
            'Solicitud'=>true,
            'listaCorreos'=>isset($info['id']) ? $this->obtenerListadoCorreo($info['id']) : [],
            'listaTelefonos'=>isset($info['id']) ? $this->obtenerListadoTels($info['id']) : []
        ]);
    }

    public function listadoMunicipios()
    {
        $municipio = new MunicipioModel();
        echo json_encode([
            'Solicitud'=>true, 
            'opciones'=>$municipio->getMunicipiosEstado($this->request->getPost('idEstado'), 'id, municipio as text')
        ]);
    }

    public function guardarInformacion()
	{
		if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }
        
        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        } 

		$contactoModel = new ContactoModel();
		$datos = [
			'nombre'=>trim($this->request->getPost('nombre')),
			'ap_paterno'=>trim($this->request->getPost('ap_paterno')),
			'estado_id'=>$this->request->getPost('estado'),
			'municipio_id'=>$this->request->getPost('municipio'), 
			'puesto_id'=>$this->request->getPost('puesto'),
			'usuario_id'=>$this->usuario->getId(),
			'cargo'=>$this->request->getPost('cargo'), 
			'organizacion_id'=>1,
		];
        if ($this->request->getPost('ap_materno')) {
            $datos['ap_materno'] = trim($this->request->getPost('ap_materno'));
        }
        $info = $contactoModel->find($this->usuario->getId());
        $id = !isset($info['id']) ? $contactoModel->insert($datos) : $contactoModel->update($info['id'], $datos);
        $id = isset($info['id']) ? $info['id'] : $id;
        if (!$id) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar '.isset($info['id'])?'actualizar':'guardar'.' la información.']);return;
        }
        $completa = false;
        if ($this->agregarCorreos($this->request->getPost('correos'), $id) && $this->agregarTelefonos($this->request->getPost('telefonos'), $id)) {            
            $completa = $contactoModel->update($id, ['info_completa'=>1]);
        }
		if ($completa) {
            echo json_encode(['Solicitud'=>true, 'Msg'=>'Información actualizada correctamente, perfil completo.', 'completa'=>$completa]);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Información actualizada correctamente.', 'completa'=>$completa]);
	}

    protected function agregarCorreos($listado, $idContacto)
    {
        $emailModel = new CorreoModel();
        $insertado = false; $ids = [];
        foreach ($listado as $email) {
            if (is_numeric($email['id'])) {
                $ids[] = $email['id'];
                continue;
            }
            unset($email['id']);
            $email['contacto_id'] = $idContacto;

            if ( ($id=$emailModel->insert($email)) ) {
                $insertado = true;
                $ids[] = $id;
            }
        }
        if (count($ids)>0) {
            $emailModel->whereNotIn('id', $ids)->set(['estatus' => 0])->update();
        }
        return $insertado;
    }

    protected function agregarTelefonos($listado, $idContacto)
    {   
        $telModel = new TelefonoModel();
        $insertado = false; $ids = [];
        foreach ($listado as $telefono) {
            if (is_numeric($telefono['id'])) {
                $ids[] = $telefono['id'];
                continue;
            }

            unset($telefono['id']);
            $telefono['contacto_id'] = $idContacto;

            if (!is_numeric($telefono['lada'])) {
                unset($telefono['lada']);
            }
            if (!is_numeric($telefono['extension'])) {
                unset($telefono['extension']);
            }
            if ( ($id=$telModel->insert($telefono)) ) {
                $insertado = true;
                $ids[] = $id;
            }
        }
        if (count($ids)>0) {
            $telModel->whereNotIn('id', $ids)->set(['estatus' => 0])->update();
        }
        return $insertado;
    }

	protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            [
				'nombre'=>$this->request->getPost('nombre'),
				'ap_paterno'=>$this->request->getPost('ap_paterno'),
				'puesto'=>$this->request->getPost('puesto'),
				'estado'=>$this->request->getPost('estado'),
				'municipio'=>$this->request->getPost('municipio'), 
				'cargo'=>$this->request->getPost('cargo'), 
			],
            'contact'
        );
        
        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
        if ($validation->hasError('ap_paterno')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('ap_paterno')];
        }
		if ($validation->hasError('puesto')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('puesto')];
        }
		if ($validation->hasError('estado')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('estado')];
        }
		if ($validation->hasError('municipio')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('municipio')];
        }
		if ($validation->hasError('cargo')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('cargo')];
        }
        return ['Solicitud'=>true];
    }

    protected function obtenerListadoCorreo($idContacto=null)
    {
        $perfil = new CPerfil();
        $datos = $perfil->getCatalogo(
			'gp_correos c left join cat_tipo_correos t on(c.tipo=t.id)', 'c.*, t.tipo', 
			null, is_numeric($idContacto) ? "c.contacto_id={$idContacto} AND c.estatus=1" : null
		);
        return is_array($datos) ? $datos : [];
    }

    protected function obtenerListadoTels($idContacto=null)
    {
        $perfil = new CPerfil();
        $datos = $perfil->getCatalogo(
			'gp_telefonos t left join cat_tipo_telefonos tt on(t.tipo=tt.id)', 't.*, tt.tipo', 
			null, is_numeric($idContacto) ? "t.contacto_id={$idContacto} AND t.estatus=1" : null
		);
        return is_array($datos) ? $datos : [];
    }
    
}
