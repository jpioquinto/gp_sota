<?php 
namespace App\Libraries;

class Archivo
{
    const MB = 1048576;
	protected $size;

    public function __construct($size=2)
    {        
		$this->size = $size;        
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function sizePermitido()
	{
		return self::MB * $this->getSize();
	}

    public function obtenExtension($archivo)
    {
        $ext = explode(".", $archivo);
		$ext = end($ext);

		return $ext == "" ? 'pdf' : $ext;
    }

}
