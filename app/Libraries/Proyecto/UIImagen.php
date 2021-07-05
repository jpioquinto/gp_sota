<?php 
namespace App\Libraries\Proyecto;
use App\Models\ImagenModel;

class UIImagen
{
    protected $imagenModel;
    protected $proyecto;

    public function __construct(CProyecto $proyecto)
    {
        $this->imagenModel = new ImagenModel();  
        $this->proyecto = $proyecto;      
    }
    
    public function obtenerListado()
    {
        $html = '';
        foreach ($this->consultarImagenes() as $imagen) {
            $html .= view('proyectos/multimedia/parcial/_v_item_media.php', $imagen);
        }
        return $html;
    }

    public function consultarImagenes()
    {
        return $this->imagenModel
        ->where(['estatus'=>1, 'proyecto_id'=>$this->proyecto->getId()])
        ->orderBy('nombre', 'ASC')
        ->findAll();
    }
}
