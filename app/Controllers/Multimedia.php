<?php
namespace App\Controllers;

use App\Libraries\Proyecto\Multimedia\{Multimedia AS CMultimedia, Foto, Video, UIFoto, UIVideo};
use App\Libraries\Proyecto\{CProyecto};
use App\Traits\CifradoTrait;
use App\Libraries\Usuario;

class Multimedia extends BaseController
{   
    protected $encrypter; 
    protected $usuario;
    const _SPACE_ = "App\Libraries\Proyecto\Multimedia\\";

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
        #$uiImagen = new UIFoto($proyecto);

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

    public function obtenerMultimedia()
    {
        $params = $this->request->getPost();

        $proyecto = new CProyecto($this->desencriptar( base64_decode($params['proyectoId']) ));

        $clase = self::_SPACE_.'UI'.ucwords($params['media']);
        
        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta vista.']); return; 
        }  
              
        $uiMedia = new $clase($proyecto, $params);
        
        $listado = $params['ini']==='false'
                ? '<div class="row content-media">'.$uiMedia->obtenerListado($uiMedia->offset(), $uiMedia->limit()).'</div>'
                : $uiMedia->obtenerListado($uiMedia->offset(), $uiMedia->limit());
        
        ++$params['pagina'];
        
        if ($params['ini']==='false') {            
            $params['ini'] = true;
            $params['total'] = count($uiMedia->consultarMedia());
            $listado .= ($params['pagina']*$params['paginacion'])<$params['total'] ? view('proyectos/multimedia/parcial/_v_mas_media') : '';
        }
        
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>$listado,            
            'info'=>$params
        ]);
    }

    public function vistaFormulario()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}
        #var_dump( $this->request->getPost());exit;
        $form = [
            'media'=>$this->request->getPost('media'), 
            'accept'=>$this->request->getPost('media')=='foto' ? '.jpg, .jpeg, .png, .gif, .bmp, .webp, .tif, .tiff' : '.mpeg, .ogv, .webm, .3gp, .3g2, .avi, .flv, .mp4, .ts, .mov, .wmv, .mkv'
        ];
		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/multimedia/parcial/_v_modal_media',
                [
                    'vistaContenedor'=>view('proyectos/multimedia/parcial/_v_form_media', $form),
                    'media'=> ucwords($this->request->getPost('media'))
                ]
            )
        ]);	
    }

    public function vistaVerMedia()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

        $clase = self::_SPACE_.'UI'.ucwords($this->request->getPost('media'));

        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta vista.']); return; 
        }  

        $proyecto = new CProyecto($this->desencriptar( base64_decode($this->request->getPost('proyectoId')) ));
        
        $uiMedia = new $clase($proyecto);

		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/multimedia/parcial/_v_modal_show_media', 
                [
                    'v_media'=>$uiMedia->vistaMedia($this->desencriptar( base64_decode($this->request->getPost('id')) ), $this->usuario->obtenerPermisosModulo('Proyecto'))
                ]
            )
        ]);	
    }

    public function guardarImagen()
    {
        if (!$this->request->getPost('proyectoId')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador del Proyecto.',
            ]);	
            return; 
        }

        $image = \Config\Services::image()
                ->withFile($this->request->getFile('foto'));

        $media = new CMultimedia(new Foto);
        echo json_encode($media->guardar($this->request, new CProyecto($this->desencriptar(base64_decode($this->request->getPost('proyectoId')))), $image) );
    }

    public function guardarVideo()
    {
        if (!$this->request->getPost('proyectoId')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador del Proyecto.',
            ]);	
            return; 
        }

        $media = new CMultimedia(new Video);
        echo json_encode($media->guardar($this->request, new CProyecto($this->desencriptar(base64_decode($this->request->getPost('proyectoId')))), $this->request->getFile('video')) );
    }
}
