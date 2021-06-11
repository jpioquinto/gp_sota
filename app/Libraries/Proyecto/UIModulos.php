<?php 
namespace App\Libraries\Proyecto;
use App\Models\SubModuloModel;


class UIModulos
{
    protected $items;

    public function __construct()
    {   
        $this->items = '';        
    }

    public function listadoSubmodulos($col=6)
    {
        $htmlItem = '<div class="row">'; $ulitmoModulo = '';

        $submodulos = $this->obtenerSubmodulos();
        foreach ($submodulos as $key => $submodulo) {
            if ($key == (count($submodulos)-1)) {
                $ulitmoModulo .= $this->htmlItem( $submodulo ); continue;
            }
            $htmlItem .= "<div class='col-md-{$col}'>".$this->htmlItem( $submodulo )."</div>";
        }
        return ['modulos'=> $htmlItem.'</div>', 'ultimoModulo'=>$ulitmoModulo];

    }

    public function htmlItem($submodulo)
    {
        return view('proyectos/parcial/_v_card_modulo', $submodulo);
    }

    public function obtenerSubmodulos()
    {
        $criterioModel = new SubModuloModel();
        return $criterioModel->where('estatus',1)->orderBy('orden')->findAll();
    }
}
