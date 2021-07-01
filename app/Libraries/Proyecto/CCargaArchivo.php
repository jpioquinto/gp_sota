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
        
        $nombre = $this->verificaDuplicados($nombre ? $nombre.'.'.$this->obtenExtension($archivo->getName()) : $archivo->getName());
        
        $archivo->move( $this->getDirectorio(), $nombre );

        if (!$archivo->hasMoved()) {
            return [
                'Solicitud' =>false,'Error'=>'Error intentar cargar el archivo: '.$archivo->getName()
            ];	            
        }

        return ['Solicitud'=>true, 'nombre'=>$nombre, 'extension'=>$this->obtenExtension($archivo->getName()), 'url'=>$this->getDirectorio().$nombre];
    }
    
    public function existeDirectorio()
    {
        return !is_dir($this->ruta) ? mkdir($this->ruta, 0777, true) : true;
    }

    public function getDirectorio()
    {
        return $this->ruta;
    }

    public function verificaDuplicados($nombre, $consecutivo=0)
    {
        $_nombre = $this->quitaExtension($nombre);
		$buscar  = glob($this->getDirectorio().$_nombre."*.*");

		if ($buscar==FALSE || (is_array($buscar) && count($buscar)==0)) {
			return $nombre;
		}

        $consecutivo = $consecutivo > 0 ? $consecutivo : count($buscar) + 1;
		if (file_exists( $this->getDirectorio().$_nombre . '-'.$consecutivo.'.'.$this->obtenExtension($nombre) )) {
			return $this->verificaDuplicados( $nombre, ++$consecutivo );
		}

		return $_nombre . '-'.$consecutivo.'.'.$this->obtenExtension($nombre);
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
