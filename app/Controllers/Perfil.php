<?php

namespace App\Controllers;
use App\Models\MunicipioModel;
use App\Models\{ContactoModel, TelefonoModel, CorreoModel};
use  App\Libraries\Usuario;

class Perfil extends BaseController
{   
    protected $usuario;     
    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();              
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

		$contacto = new ContactoModel();
		$datos = [
			'nombre'=>$this->request->getPost('nombre'),
			'ap_paterno'=>$this->request->getPost('ap_paterno'),
			'estado'=>$this->request->getPost('estado'),
			'municipio'=>$this->request->getPost('municipio'), 
			'puesto'=>$this->request->getPost('puesto'),
			'usuario_id'=>$this->usuario->getUsuarioId(),
			'cargo'=>$this->request->getPost('cargo'), 
			'organizacion_id'=>1,
		];
        if (($id = $contacto->insert($datos))<=0) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar guardar la información.']);return;
        }
        $completa = false;
        if ($this->agregarCorreos($this->request->getPost('correos'), $id) && $this->agregarTelefonos($this->request->getPost('telefonos'), $id)) {            
            $completa = $contacto->update($id, ['info_completa'=>1]);
        }
		if ($completa) {
            echo json_encode(['Solicitud'=>true, 'Msg'=>'Información actualizada correctamente, perfil completo.', 'completa'=>$completa]);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Información actualizada correctamente.', 'completa'=>$completa]);
	}

    protected function agregarCorreos($listado, $idContacto)
    {
        $emailModel = new CorreoModel();
        $insertado = false;
        foreach ($listado as $email) {
            unset($email['id']);
            $email['contacto_id'] = $idContacto;
            if ($emailModel->save($email)) {
                $insertado = true;
            }
        }
        return $insertado;
    }

    protected function agregarTelefonos($listado, $idContacto)
    {   
        $telModel = new TelefonoModel();
        $insertado = false;
        foreach ($listado as $telefono) { 
            unset($telefono['id']);
            $telefono['contacto_id'] = $idContacto;
            if (!is_numeric($telefono['lada'])) {
                unset($telefono['lada']);
            }
            if (!is_numeric($telefono['extension'])) {
                unset($telefono['extension']);
            }
            if ($telModel->save($telefono)) {
                $insertado = true;
            }
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
    
}
