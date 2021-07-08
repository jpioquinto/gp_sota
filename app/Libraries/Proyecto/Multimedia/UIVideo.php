<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;
use App\Models\VideoModel;

class UIVideo
{
    protected $videoModel;
    protected $encrypter; 
    protected $proyecto;

    use CifradoTrait;

    public function __construct(CProyecto $proyecto)
    {
        $this->encrypter = \Config\Services::encrypter();  
        $this->videoModel = new VideoModel(); 
        $this->proyecto = $proyecto;      
    }
    
    public function obtenerListado()
    {
        $html = '';
        foreach ($this->consultarVideos() as $video) {
            $video['id'] = base64_encode( $this->encriptar($video['id']) );
            $html .= view('proyectos/multimedia/parcial/_v_item_video', $video);
        }
        return $html;
    }

    public function consultarVideos()
    {
        return $this->videoModel
        ->where(['estatus'=>1, 'proyecto_id'=>$this->proyecto->getId()])
        ->orderBy('nombre', 'ASC')
        ->findAll();
    }

    public function obtenerMedia($id)
    {
        return $this->videoModel->find($id) ?? [];
    }

    public function vistaMedia($id, $permisos)
    {
        $media = $this->obtenerMedia($id); 

        if (isset($media['id'])) {
            $media['id'] = base64_encode($this->encriptar($media['id']));
        }

        return view(
            'proyectos/multimedia/parcial/_v_show_video', array_merge($media, ['permisos'=>$permisos])
        );
    }
}
