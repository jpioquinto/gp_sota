<?php

namespace App\Controllers;

use App\Libraries\Proyecto\UIProyecto;
use App\Models\ProyectoModel;
use App\Libraries\Usuario;

class Proyecto extends BaseController
{   
    protected $uiProyecto;  
    protected $encrypter; 
    protected $usuario;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();  
        $this->uiProyecto = new UIProyecto();  
        $this->encrypter = \Config\Services::encrypter();                   
    }

    public function index()
    {            
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_listado', 
                [
                    'listado'=>$this->uiProyecto->obtenerListado(), 
                ])
            ]);
    }

    public function indexddsdadasda()
    {
        
        
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_form_proyecto', 
                [
                    'v_acciones'=> view('proyectos/parcial/_v_acciones'),
                    'v_listado_tipos'=>$this->uiProyecto->listadoTipos(),
                    'v_listado_cobertura'=>$this->uiProyecto->listadoCoberturas(),
                    'v_listado_usuarios'=>$this->uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId())                    
                ])
            ]);
    }

    public function guardar()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }

        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        }

        $datos = [
			'nombre'=>trim($this->request->getPost('nombre')),
			'alias'=>trim($this->request->getPost('alias')),
			'descripcion'=>$this->request->getPost('descripcion'),
			'tipo_id'=>$this->request->getPost('tipo'), 
			'cobertura_id'=>$this->request->getPost('cobertura'),
			'fecha_incorporacion'=>$this->request->getPost('incorporacion'), 
            'coordinador_id'=>$this->request->getPost('coordinador'),
            'responsable_id'=>$this->request->getPost('responsable'),
            'colaboradores'=>implode(',', $this->request->getPost('colaboradores')),
		];

        if (trim($this->request->getPost('claves')) !='' ) {
            $datos['palabra_clave'] = trim($this->request->getPost('claves'));
        }

        if (trim($this->request->getPost('objetivo')) !='' ) {
            $datos['objetivo'] = trim($this->request->getPost('objetivo'));
        }

        if (trim($this->request->getPost('nota')) !='' ) {
            $datos['nota'] = trim($this->request->getPost('nota'));
        }

        if (!$this->request->getPost('id')) {
            $datos['organizacion_id'] = $this->usuario->getOrganizacionId();
            $datos['creado_por'] = $this->usuario->getId();
        }

        $id = $this->insertarActualizar($datos, $this->request->getPost('id'));
        if ( !is_numeric($id) || $id<1 ) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar '.($this->request->getPost('id') ? 'actualizar' : 'crear').'  la Ficha Técnica.'
            ]);
            return;
        }

        echo json_encode([
            'Solicitud'=>true, 
            'Msg'=>'Ficha Técnica '.($this->request->getPost('id') ? 'actualizada correctamente.' : 'creada correctamente.')
        ]);

    }

    protected function insertarActualizar($datos, $id=null)
    {
        $proyectoModel = new ProyectoModel();
        if (!$id) {
            return $proyectoModel->insert($datos); 
        }
 
        $proyectoModel->update( $this->encrypter->decrypt(base64_decode($id)), $datos );

        return $this->encrypter->decrypt(base64_decode($id));

    }

    protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            [
				'nombre'=>$this->request->getPost('nombre'),
				'alias'=>$this->request->getPost('alias'),
				'descripcion'=>$this->request->getPost('descripcion'),
				'tipo'=>$this->request->getPost('tipo'),
				'cobertura'=>$this->request->getPost('cobertura'), 
				'incorporacion'=>$this->request->getPost('incorporacion'),
                'coordinador'=>$this->request->getPost('coordinador'),
                'responsable'=>$this->request->getPost('responsable'),
                #'colaboradores'=>$this->request->getPost('colaboradores'), 
			],
            'project'
        );
        
        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
        if ($validation->hasError('alias')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('alias')];
        }
		if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('tipo')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('tipo')];
        }
		if ($validation->hasError('cobertura')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('cobertura')];
        }
		if ($validation->hasError('incorporacion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('incorporacion')];
        }
        if ($validation->hasError('coordinador')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('coordinador')];
        }
        if ($validation->hasError('responsable')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('responsable')];
        }
        /*if ($validation->hasError('colaboradores')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('colaboradores')];
        }*/
        return ['Solicitud'=>true];
    }

}
