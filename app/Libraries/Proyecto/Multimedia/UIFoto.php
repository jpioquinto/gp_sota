<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Models\{ImagenModel, ImagenQuery};

class UIFoto extends UIMedia
{
    protected $imagenModel;

    public function __construct(CProyecto $proyecto, $params = [])
    {        
        $this->imagenModel = new ImagenModel();         
        parent::__construct($proyecto, $params);   
    }
    
    public function obtenerListado($offset=null, $limit=null)
    {
        $html = '';
        $imagenes = $this->consultarMedia($offset, $limit);
        foreach ($imagenes as $imagen) {
            $imagen['id'] = base64_encode( $this->encriptar($imagen['id']) );
            $html .= view('proyectos/multimedia/parcial/_v_item_media.php', $imagen);
        }
        $this->setCount(count($imagenes));

        return $html;
    }

    public function queryMedia($offset=null, $limit=null)
    {
        $imagenQuery = new ImagenQuery();
        return $imagenQuery->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId()], $this->busqueda(), $offset, $limit);
    }

    public function consultarMedia($offset=null, $limit=null)
    {
        if ($this->busqueda()!='') {
            return $this->queryMedia($offset, $limit);
        }

        $registros = $this->imagenModel
        ->where(['estatus'=>1, 'proyecto_id'=>$this->proyecto->getId()])
        ->orderBy('nombre', 'ASC');

        if (!is_null($limit) && !is_null($offset)) {
            return $registros->findAll($limit, $offset);
        }

        return $registros->findAll();
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
