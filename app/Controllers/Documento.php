<?php
namespace App\Controllers;

use App\Libraries\Proyecto\Documento\{UIDocumento, Gestor};
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

        helper('util');
                
        $clase = self::_SPACE_.str_replace(' ', '', ucwords(limpiarCadena($this->request->getPost('form'))));

        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta acción.']); return; 
        }  

        $gestor = new Gestor(new $clase(new CProyecto($this->desencriptar( base64_decode($this->request->getPost('proyectoId')) ))));
        
		echo json_encode([
            'Solicitud'=>true,
            'vista'=>$gestor->vista()
        ]);	
    }

    public function cargarArchivo()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador del Proyecto.',
            ]);	
            return; 
        }
        
        helper('util');
                
        $clase = self::_SPACE_.str_replace(' ', '', ucwords(limpiarCadena($this->request->getPost('tipo_doc'))));

        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta acción.']); return; 
        }  

        $gestor = new Gestor(new $clase(new CProyecto($this->desencriptar( base64_decode($this->request->getPost('id')) ))));

        /*
        $cargaArchivo = new CCargaArchivo(new CProyecto( $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))) ));
        $carga = $cargaArchivo->mover(
            $this->request->getFile('archivo'), 
            $this->generarNombre( $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))) )
        );
        
        if (!$carga['Solicitud']) {
            echo json_encode($carga);return;
        }
                
        $this->guardarEvidencia([            
            'proyecto_id'=> $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))),
            'registro_id'=> $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))),            
            'bloque'=>$this->request->getPost('bloque') ? $this->request->getPost('bloque') : '',
            'descripcion'=>$this->request->getPost('descripcion'),
            'creado_por'=>$this->usuario->getId(),
            'seccion'=> self::SECCION,
            'ruta'=>$carga['url'],
        ]);
        */
        echo json_encode($gestor->guardar($this->request->getPost(), $this->request->getFile('archivo')));

    }
}
