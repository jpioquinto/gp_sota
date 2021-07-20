<?php
namespace App\Controllers;

use App\Libraries\Proyecto\Documento\{UIDocumento};
use App\Libraries\Proyecto\{CProyecto};
use App\Traits\CifradoTrait;
use App\Libraries\Usuario;

class Documento extends BaseController
{   
    protected $encrypter; 
    protected $usuario;
    const _SPACE_ = "App\Libraries\Proyecto\Documento\\";

    use CifradoTrait;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();  
        $this->encrypter = \Config\Services::encrypter();                   
    }

    public function index()
    {        
        $proyecto = new CProyecto($this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ));
        
        $infoProyecto = $proyecto->obtenerProyecto();
        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
                'proyectos/documentos/v_contenedor', 
                [
                    'docs'=>'',
                    'permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')
                ]),
            'header'=>view(
                'proyectos/parcial/_v_header_titulo', 
                [
                    'alias'=>'Documentos'.(isset($infoProyecto['alias']) ? ' - '.$infoProyecto['alias'] : ''), 
                    'v_acciones'=>headerRegresar()
                ])
        ]);
    }

    public function vistaModalCarga()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

        $uiDoc = new UIDocumento(new CProyecto($this->desencriptar( base64_decode($this->request->getPost('id')) )));
        
        $form = [
            
        ];
		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/documentos/parcial/_v_modal_doc',
                [
                    'vistaContenedor'=>view('proyectos/documentos/parcial/_v_form_planeacion', $form),  
                    'tipo_doc' => $uiDoc->listado($uiDoc->getCatalogo(), 5)                   
                ]
            )
        ]);	
    }

    public function vistaFormulario()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}
        echo '<pre>';print_r($this->request->getPost());exit;
        $uiDoc = new UIDocumento(new CProyecto($this->desencriptar( base64_decode($this->request->getPost('id')) )));
        
        $form = [
            
        ];
		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/documentos/parcial/_v_modal_doc',
                [
                    'vistaContenedor'=>view('proyectos/documentos/parcial/_v_form_planeacion', $form),  
                    'tipo_doc' => $uiDoc->listado($uiDoc->getCatalogo(), 5)                   
                ]
            )
        ]);	
    }
}
