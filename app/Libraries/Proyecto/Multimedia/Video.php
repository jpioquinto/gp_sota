<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo};
use App\Libraries\Validacion\ValidaMedia;
use App\Models\VideoModel;
use App\Libraries\Usuario;

class Video extends Media
{
    public function __construct()
    {
        helper('util');
        @session_start();   
        $this->usuario = new Usuario();  
        $this->encrypter = \Config\Services::encrypter();  
    }

    public function guardar($request, CProyecto $proyecto, $archivo)
    {        
        $carga = new CCargaArchivo($proyecto, 'multimedia/videos');
        #var_dump($carga->verificaDuplicados( limpiarCadena($archivo->getName()) ));exit;
        $campos = [
            'proyecto_id'=>$this->desencriptar(base64_decode($request->getPost('proyectoId'))),
            'nombre'=>$nombre=$carga->verificaDuplicados( limpiarCadena($archivo->getName()) ),
            'ruta'=>$carga->getDirectorio().$nombre,
            'descripcion'=>trim($request->getPost('descripcion')),
            'autor'=>trim($request->getPost('autor')),
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),            
            'resolucion'=>0,
            'tamanio'=>$archivo->getSize(),
            'p_serie'=>$request->getPost('p_serie'),            
            'creado_por'=>$this->usuario->getId(),
        ];
        
        $validacion = new ValidaMedia();

        $validar = $validacion->esSolicitudVideoValida($campos);

        if ($validar['Solicitud']===FALSE) {
            return $validar;
        }

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
        }
    
        $mover = $carga->mover($archivo, quitaExtension($campos['nombre'])); 
        
        if (!$mover['Solicitud']) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar el video.'];
        }

        $campos['nombre'] = $mover['nombre'];
        $campos['ruta'] = $mover['url'];
                
        if ($request->getPost('clave') && !empty($request->getPost('clave'))) {
            $campos['palabra_clave'] = str_replace(',', ' ', $request->getPost('clave'));
        }

        if (!empty($request->getPost('licencia'))) {
            $campos['licencia'] = trim( $request->getPost('licencia') );
        }

        $videoModel = new VideoModel();
        
        return $videoModel->insert($campos)
        ? ['Solicitud'=>true, 'Msg'=>'Video cargado correctamente.']
        : ['Solicitud'=>false, 'Msg'=>'Error al intentar registrar la carga del video.'];       
    }
}
