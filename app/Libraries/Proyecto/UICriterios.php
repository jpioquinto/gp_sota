<?php 
namespace App\Libraries\Proyecto;
use App\Models\CriterioModel;


class UICriterios
{
    protected $items;

    public function __construct()
    {   $this->items = '';
        
    }

    public function listadoItems()
    {  
         if ($this->items=='') {
            $this->items = $this->generarListado();
        }     
        return $this->items;
    }

    public function generarListado()
    {
        $htmlItem = '';
        $criterios = $this->obtenerCriterios();
        foreach ($criterios as $key => $criterio) {
            $htmlItem .= $this->htmlItem($criterio);
        }
        return $htmlItem;
    }

    public function htmlItem($criterio, $separador = true)
    {
        return "<a class='dropdown-item' href='' onclick='return false;'>
                        <i class='{$criterio['icono']}'></i>  {$criterio['descripcion']}
                </a>".($separador ? $this->separador() : '');
    }

    public function obtenerCriterios()
    {
        $criterioModel = new CriterioModel();
        return $criterioModel->where('estatus',1)->orderBy('orden')->findAll();
    }

    public function separador()
    {
        return '<div role="separator" class="dropdown-divider"></div>';
    }
}
