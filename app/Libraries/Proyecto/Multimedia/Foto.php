<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo};
use App\Libraries\Validacion\ValidaMedia;
use App\Models\ImagenModel;
use App\Libraries\Usuario;

class Foto extends Media
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
        $carga = new CCargaArchivo($proyecto, 'multimedia/imagenes');

        if ($archivo->getHeight()<800) {
            $this->redimensionarAltura($archivo, 600);
        }

        $campos = [
            'proyecto_id'=>$this->desencriptar(base64_decode($request->getPost('proyectoId'))),
            'nombre'=>$nombre=$carga->verificaDuplicados( limpiarCadena($request->getFile('foto')->getName()) ),
            'ruta'=>$carga->getDirectorio().$nombre,
            'descripcion'=>trim($request->getPost('descripcion')),
            'autor'=>trim($request->getPost('autor')),
            'formato'=>strtolower( obtenExtension($request->getFile('foto')->getName()) ),            
            'resolucion'=>$archivo->getWidth() . 'x' . $archivo->getHeight(),
            'tamanio'=>$archivo->getSize(),
            'p_serie'=>$request->getPost('p_serie'),            
            'creado_por'=>$this->usuario->getId(),
        ];
        
        $validacion = new ValidaMedia();

        $validar = $validacion->esSolicitudImagenValida($campos);

        if ($validar['Solicitud']===FALSE) {
            return $validar;
        }

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
        }
               
        if (!$archivo->save($campos['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar la imagen.'];
        }
                
        if ($request->getPost('clave') && !empty($request->getPost('clave'))) {
            $campos['palabra_clave'] = str_replace(',', ' ', $request->getPost('clave'));
        }

        if (!empty($request->getPost('licencia'))) {
            $campos['licencia'] = trim( $request->getPost('licencia') );
        }

        $imagenModel = new ImagenModel();
        
        return $imagenModel->insert($campos)
        ? ['Solicitud'=>true, 'Msg'=>'Imagen cargada correctamente.']
        : ['Solicitud'=>false, 'Msg'=>'Error al intentar registrar la carga de la imagen.'];       
    }

    public function redimensionarAltura(&$imagen, $alto = 800, $maintainRatio = false, $masterDim = 'auto')
    {
        $ancho = $imagen->getWidth();#round( ($alto * $imagen->getWidth()) / $imagen->getHeight() );
        return $imagen->resize($ancho, $alto, $maintainRatio, $masterDim);        
    }
}
