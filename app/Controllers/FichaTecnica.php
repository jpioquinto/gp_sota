<?php

namespace App\Controllers;

use App\Libraries\Proyecto\{UIProyecto, CProyecto, CFichaTecnica};
use App\Libraries\Usuario;

class FichaTecnica extends BaseController
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
        $proyecto = new CProyecto( $this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ) );
        
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/v_form_proyecto', 
                [   
                    'id'=>$this->request->getPost('id'),
                    'proyecto'=>($registro=$proyecto->obtenerProyecto()),
                    'v_acciones'=> view('proyectos/parcial/_v_acciones', ['permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto'), 'submodulo'=>true]),
                    'v_listado_tipos'=>$this->uiProyecto->listadoTipos(isset($registro['tipo_id']) ? $registro['tipo_id'] : null),
                    'v_listado_cobertura'=>$this->uiProyecto->listadoCoberturas(isset($registro['cobertura_id']) ? $registro['cobertura_id'] : null),
                    'v_listado_coordinadores'=>$this->uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId(),isset($registro['coordinador_id']) ? $registro['coordinador_id'] : null), 
                    'v_listado_responsables'=>$this->uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId(),isset($registro['responsable_id']) ? $registro['responsable_id'] : null),
                    'v_listado_colaboradores'=>$this->uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId(),isset($registro['colaboradores']) ? $registro['colaboradores'] : null)                     
                ])
            ]);
    }

    public function cargarFoto()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador de la Ficha Técnica.',
            ]);	
            return; 
        }
        
        $foto = $this->request->getFile('foto');
        #echo '<pre>';  print_r($foto);exit;
        if (!in_array($foto->getMimeType(), ['image/png', 'image/jpeg', 'image/jp2'])) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'El formato del archivo que intenta cargar no esta permitido.',
            ]);	
            return;
        }

        $ficha = new CFichaTecnica( new CProyecto( $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))) ) );

        echo json_encode($ficha->moverFoto($foto));
    }

}
