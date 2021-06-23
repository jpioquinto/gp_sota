<?php 
namespace App\Libraries\Proyecto;

class CFichaTecnica
{	
    protected $proyecto;
    protected $ruta;
    protected $height;
    protected $width;

    public function __construct(CProyecto $proyecto, $width=618, $height=391)
    {
        $this->proyecto = $proyecto;
        $this->width = $width;
        $this->height = $height;
    }

    public function moverFoto($foto)
    {
        if ($this->proyecto->getAlias()=='') {
            return ['Solicitud'=>false, 'Error'=>'No se encontraron datos del Proyecto.'];
        }
        
        helper('util');

        if (!$this->verificarDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio destino.'];
        }

        $image = \Config\Services::image()
                ->withFile($foto)
                ->resize($this->width, $this->height)
                ->save($url = $this->ruta . strtolower($this->proyecto->getAlias()) . '.' . obtenExtension($foto->getName()));
        
        if (!$image) {
            return ['Solicitud'=>false, 'Error'=>'Error al cargar la imagen.'];
        }

        $this->guardarRuta(['imagen'=>$url, 'id'=>$this->proyecto->getId()]);

        return ['Solicitud'=>true, 'Msg'=>'Imagen cargada correctamente.', 'url'=>$url];
    }

    public function verificarDirectorio()
    {
        $this->ruta = 'documentos/' . $this->proyecto->getCarpeta() . '/' . $this->proyecto->getAnio() .'/' . $this->proyecto->getAlias() . '/fotos/';
        
        if (!($directorio = is_dir($this->ruta)) ) {
            $directorio = mkdir($this->ruta,0777,true);
        }

        return $directorio;
    }

    public function guardarRuta($campos)
    {
        $this->proyecto->actualizaProyecto($campos);
    }
}
