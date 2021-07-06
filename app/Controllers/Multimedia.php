<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo, UIImagen};
use App\Libraries\Validacion\ValidaMedia;
use App\Traits\CifradoTrait;
use App\Models\ImagenModel;
use App\Libraries\Usuario;

class Multimedia extends BaseController
{   
    protected $encrypter; 
    protected $usuario;

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
        $uiImagen = new UIImagen($proyecto);

        $infoProyecto = $proyecto->obtenerProyecto();
        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
                'proyectos/multimedia/v_contenedor', 
                [
                    'fotos'=>'<div class="row">'.$uiImagen->obtenerListado().'</div>',
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
        #var_dump( $this->request->getPost());exit;
        $form = [
            'media'=>$this->request->getPost('media'), 
            'accept'=>$this->request->getPost('foto') ? '.jpg, .jpeg, .png, .gif, .bmp, .webp, .tif, .tiff' : '.mpeg, .ogv, .webm, .3gp, .3g2, .avi, .flv, .mp4, .ts, .mov, .wmv, .mkv'
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

    public function vistaVerImagen()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}

        $proyecto = new CProyecto($this->desencriptar( base64_decode($this->request->getPost('proyectoId')) ));
        $uiImagen = new UIImagen($proyecto);
        $imagen = $uiImagen->obtenerImagen($this->desencriptar( base64_decode($this->request->getPost('id')) ));
        
        if (isset($imagen['id'])) {
            $imagen['id'] = $this->request->getPost('id');
        }
		echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
			    'proyectos/multimedia/parcial/_v_modal_show_media', array_merge($imagen, ['permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')])
            )
        ]);	

    }

    public function guardarImagen()
    {
        if (!$this->request->getPost('proyectoId')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador de la Acción.',
            ]);	
            return; 
        }

        helper('util');

        $carga = new CCargaArchivo(new CProyecto($this->desencriptar(base64_decode($this->request->getPost('proyectoId')))), 'multimedia/imagenes');

        $image = \Config\Services::image()
                ->withFile($this->request->getFile('foto'));
        if ($image->getHeight()<800) {
            $this->redimensionarAltura($image, 600);
        }

        $campos = [
            'proyecto_id'=>$this->desencriptar(base64_decode($this->request->getPost('proyectoId'))),
            'nombre'=>$nombre=$carga->verificaDuplicados( limpiarCadena($this->request->getFile('foto')->getName()) ),
            'ruta'=>$carga->getDirectorio().$nombre,
            'descripcion'=>trim($this->request->getPost('descripcion')),
            'autor'=>trim($this->request->getPost('autor')),
            'formato'=>strtolower( obtenExtension($this->request->getFile('foto')->getName()) ),            
            'resolucion'=>$image->getWidth() . 'x' . $image->getHeight(),
            'tamanio'=>$image->getSize(),
            'p_serie'=>$this->request->getPost('p_serie'),            
            'creado_por'=>$this->usuario->getId(),
        ];
        
        $validacion = new ValidaMedia();

        $validar = $validacion->esSolicitudImagenValida($campos);

        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        }

        if (!$carga->existeDirectorio()) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()]);return;
        }

               
        if (!$image->save($campos['ruta'])) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar cargar la imagen.']);return;
        }
                
        if ($this->request->getPost('clave') && !empty($this->request->getPost('clave'))) {
            $campos['palabra_clave'] = str_replace(',', ' ', $this->request->getPost('clave'));
        }

        if (!empty($this->request->getPost('licencia'))) {
            $campos['licencia'] = trim( $this->request->getPost('licencia') );
        }

        $imagenModel = new ImagenModel();
        $imagenModel->insert($campos);

        echo json_encode(['Solicitud'=>true, 'Msg'=>'Imagen cargada correctamente.']);
    }

    public function guardarVideo()
    {
        

    }

    public function redimensionarAltura(&$imagen, $alto = 800, $maintainRatio = false, $masterDim = 'auto')
    {
        $ancho = $imagen->getWidth();#round( ($alto * $imagen->getWidth()) / $imagen->getHeight() );
        return $imagen->resize($ancho, $alto, $maintainRatio, $masterDim);        
    }
}
