<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;
use App\Models\ImagenModel;

class UIFoto
{
    protected $imagenModel;
    protected $encrypter; 
    protected $proyecto;

    use CifradoTrait;

    public function __construct(CProyecto $proyecto)
    {
        $this->encrypter = \Config\Services::encrypter();  
        $this->imagenModel = new ImagenModel(); 
        $this->proyecto = $proyecto;      
    }
    
    public function obtenerListado()
    {
        $html = '';
        foreach ($this->consultarImagenes() as $imagen) {
            $imagen['id'] = base64_encode( $this->encriptar($imagen['id']) );
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

    public function obtenerMedia($id)
    {
        return $this->imagenModel->find($id) ?? [];
    }

    public function vistaMedia($id, $permisos)
    {
        $media = $this->obtenerMedia($id); 

        if (isset($media['id'])) {
            $media['id'] = base64_encode($this->encriptar($media['id']));
        }
        
        return view(
            'proyectos/multimedia/parcial/_v_show_foto', array_merge($media, ['permisos'=>$permisos])
        );
    }
}
