<?php 
namespace App\Libraries\Proyecto;

class CCargaArchivo
{
    protected $proyecto;
    protected $ruta;

    public function __construct(CProyecto $proyecto, $carpeta='evidencias')
    {
        $this->proyecto = $proyecto;
        $this->ruta = 'documentos/'. $this->proyecto->getCarpeta() .'/'. $this->proyecto->getAnio() .'/'. $this->proyecto->getAlias() .'/'. $carpeta .'/';        
    }

    public function mover($archivo, $nombre=null)
    {
        if (!$this->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '. $this->ruta];
        }

        $nombre = $nombre ? $nombre : $this->quitaExtension($archivo->getName());
        
        $archivo->move( $ruta = $this->ruta . $nombre . $this->obtenExtension($archivo->getName()) );

        if (!$archivo->hasMoved()) {
            return [
                'Solicitud' =>false,'Error'=>'Error intentar cargar el archivo: '.$archivo->getName()
            ];	            
        }

        return ['Solicitud'=>true, 'nombre'=>$nombre, 'extension'=>$this->obtenExtension($archivo->getName()), 'url'=>$ruta];
    }
    
    public function existeDirectorio()
    {
        return !is_dir($this->ruta) ? mkdir($this->ruta, 0777, true) : true;
    }

    protected function obtenExtension($nombreArchivo)
    {
        $ext = explode(".", $nombreArchivo);
		$ext = end($ext);

		return $ext == "" ? 'undefined' : trim($ext);
    }

    protected function quitaExtension($nombre)
	{
		$ext = explode(".", $nombre);
		$ext = end($ext);

		return rtrim($nombre, ".{$ext}") == "" ? 'undefined' : rtrim($nombre, ".{$ext}");
	}
}
