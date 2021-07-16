<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Models\{VideoModel, VideoQuery};
use App\Libraries\Proyecto\CProyecto;

class UIVideo extends UIMedia
{
    protected $videoModel;

    public function __construct(CProyecto $proyecto, $params = [])
    {         
        $this->videoModel = new VideoModel();         
        parent::__construct($proyecto, $params);       
    }
    
    public function obtenerListado($offset=null, $limit=null)
    {
        $html = '';
        $videos = $this->consultarMedia($offset, $limit); 
        foreach ($videos as $video) {
            $video['id'] = base64_encode( $this->encriptar($video['id']) );
            $html .= view('proyectos/multimedia/parcial/_v_item_video', $video);
        }
        $this->setCount(count($videos));

        return $html;
    }

    public function queryMedia($offset=null, $limit=null)
    {
        $videoQuery = new VideoQuery();
        return $videoQuery->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId()], $this->busqueda(), $offset, $limit);
    }

    public function consultarMedia($offset=null, $limit=null)
    {
        if ($this->busqueda()!='') {
            return $this->queryMedia($offset, $limit);
        }

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
