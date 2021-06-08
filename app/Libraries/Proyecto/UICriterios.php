<?php 
namespace App\Libraries\Proyecto;
use App\Models\CriterioModel;


class UICriterios
{
    protected $items;

    public function __construct()
    {   $this->items = '';
        
    }

    public function contenedorTabs()
    {
        $htmlItem = '';
        $criterios = $this->obtenerCriterios();
        foreach ($criterios as $key => $criterio) {
            $htmlItem .= $this->contenedorTab( $criterio, $key==0 );
        }
        return $htmlItem;
    }

    public function contenedorTab($criterio, $first = true)
    {
        return "<div class='tab-pane fade".($first ? ' show active' : '')."' id='pills-{$criterio['id']}' role='tabpanel' aria-labelledby='pills-{$criterio['id']}-tab'>
                    {$criterio['descripcion']}
                </div>";
    }

    public function listadoTabs()
    {  
         if ($this->items=='') {
            $this->items = $this->generarTabs();
        }     
        return $this->items;
    }

    public function generarTabs()
    {
        $htmlItem = '';
        $criterios = $this->obtenerCriterios();
        foreach ($criterios as $key => $criterio) {
            $htmlItem .= $this->htmlITab( $criterio, $key==0 );
        }
        return $htmlItem;
    }

    public function htmlITab($criterio, $first = true)
    {
        return "<li class='nav-item'>
                    <a class='nav-link".($first ? ' active' :'')."' 
                        id='pills-{$criterio['id']}-tab' 
                        data-control='{$criterio['controlador']}'
                        data-toggle='pill' 
                        href='#pills-{$criterio['id']}' 
                        role='tab' 
                        aria-controls='pills-{$criterio['id']}' 
                        aria-selected='".($first ? 'true' :'false')."'
                    ><i class='{$criterio['icono']}'></i>  {$criterio['descripcion']}</a>
                </li>";
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
            $htmlItem .= $this->htmlItem( $criterio, $key<(count($criterios)-1) );
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
