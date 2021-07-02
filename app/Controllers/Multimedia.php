<?php
namespace App\Controllers;

use App\Libraries\Proyecto\CProyecto;
use App\Libraries\Usuario;

class Multimedia extends BaseController
{   
    protected $encrypter; 
    protected $usuario;

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
                'proyectos/multimedia/v_contenedor', 
                [
                    'fotos'=>'',
                    'permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')
                ]),
            'header'=>view(
                'proyectos/parcial/_v_header_titulo', 
                [
                    'alias'=>'Gelería de Fotos y Videos'.(isset($infoProyecto['alias']) ? ' - '.$infoProyecto['alias'] : ''), 
                    'v_acciones'=>headerRegresar()
                ])
        ]);
    }

    public function vistaFormulario()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/multimedia/parcial/_v_modal_media',
                ['vistaContenedor'=>view('proyectos/multimedia/parcial/_v_form_imagen')]
            )
        ]);	
    }
}
