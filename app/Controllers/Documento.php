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
        $uiDoc = new UIDocumento($proyecto);
        
        $infoProyecto = $proyecto->obtenerProyecto();
        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
                'proyectos/documentos/v_contenedor', 
                [
                    'docs'=>'',
                    'fichas'=>$uiDoc->listado($uiDoc->getCatalogo()),
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

    public function vistaModalEditar()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

        helper('util');
                
        $clase = self::_SPACE_.str_replace([' ','-'], '', ucwords(limpiarCadena(str_replace('-', ' de ', $this->request->getPost('form')))));#var_dump($clase);exit;

        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta acción.']); return; 
        }  

        $gestor = new Gestor(new $clase(new CProyecto($this->desencriptar( base64_decode($this->request->getPost('proyectoId')) ))));

		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/documentos/parcial/_v_modal_doc',
                [
                    'vistaContenedor'=>$gestor->vista($this->request->getPost('id')),                      
                    'id'=> $this->request->getPost('id')                
                ]
            )
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

    public function vistaVerDoc()
    {
        #echo '<pre>';print_r($this->request->getPost());exit;
        $visorDoc = view('proyectos/parcial/_v_visor_doc', [
            'url'=>$this->request->getPost('uri'),
            'mime'=>$this->request->getPost('mime'),
            'titulo'=>$this->request->getPost('nombre'),
        ]);

        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/parcial/_v_modal_ver_docs', ['vistaContenedor'=>$visorDoc])
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

        echo json_encode($gestor->guardar($this->request->getPost(), $this->request->getFile('archivo')));
    }

    public function obtenerDocumentos()
    {
        $params = $this->request->getPost();

        $proyecto = new CProyecto($this->desencriptar( base64_decode($params['proyectoId']) ));

        $clase = self::_SPACE_.'UIDocumento';
        
        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta vista.']); return; 
        }        
              
        $uiDoc = new $clase($proyecto, $params);
        
        $listado = $params['ini']==='false'
                ? '<div class="listado-documentos">'.$uiDoc->obtenerListado($uiDoc->offset(), $uiDoc->limit()).'</div>'
                : $uiDoc->obtenerListado($uiDoc->offset(), $uiDoc->limit());
        
        ++$params['pagina'];
        
        if ($params['ini']==='false') {            
            $params['ini'] = true;
            $params['total'] = count($uiDoc->consultarDocs());
            $listado .= ($params['pagina']*$params['paginacion'])<$params['total'] ? view('proyectos/documentos/parcial/_v_mas_docs') : '';
        }
        
        echo json_encode(['Solicitud'=>true, 'vista'=>$listado, 'info'=>$params]);
    }
}
