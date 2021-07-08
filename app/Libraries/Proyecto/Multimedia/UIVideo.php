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
    protected $count;

    use CifradoTrait;

    public function __construct(CProyecto $proyecto)
    {
        $this->encrypter = \Config\Services::encrypter();  
        $this->videoModel = new VideoModel(); 
        $this->proyecto = $proyecto;      
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }
    
    public function obtenerListado()
    {
        $html = '';
        $videos = $this->consultarMedia(); 
        foreach ($videos as $video) {
            $video['id'] = base64_encode( $this->encriptar($video['id']) );
            $html .= view('proyectos/multimedia/parcial/_v_item_video', $video);
        }
        $this->setCount(count($videos));

        return $html;
    }

    public function consultarMedia($limit=null, $offset=null)
    {
        $registros = $this->videoModel
        ->where(['estatus'=>1, 'proyecto_id'=>$this->proyecto->getId()])
        ->orderBy('nombre', 'ASC');

        if (!is_null($limit) && !is_null($offset)) {
            return $registros->findAll($limit, $offset);
        }

        return $registros->findAll();
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
