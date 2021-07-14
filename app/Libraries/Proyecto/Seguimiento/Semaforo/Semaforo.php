<?php 
namespace App\Libraries\Proyecto\Seguimiento\Semaforo;

class Semaforo
{
    protected $indicador;

    public function __construct(Indicador $indicador)
    {
        $this->indicador = $indicador;
    }

    public function getIcono()
    {
        if ($this->indicador->icono()=="") {
            return $this->indicador->icono();
        }

        return "<img 
                    src='{$this->indicador->icono()}' 
                    class='img-thumbnail' 
                    width=32 height=32 
                    data-toggle='tooltip' 
                    data-placement='bottom'
                    data-original-title='{$this->indicador->getLeyenda()}'
                />";
    }
}
