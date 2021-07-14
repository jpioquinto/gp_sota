<?php 
namespace App\Libraries\Proyecto\Seguimiento;

class EstatusAccion implements ISemaforo
{
    protected $tiempo;
    protected $avance;
    protected $rangos;
    protected $porc;
    
    public function __construct($tiempo, $avance)
    {
        $this->rangos = [
            ['min'=>0,  'max'=>20,  'estatus'=>1, 'icon'=>'images/iconos/semaforo/estatus-1.png'],
            ['min'=>21, 'max'=>40,  'estatus'=>2, 'icon'=>'images/iconos/semaforo/estatus-2.png'],
            ['min'=>41, 'max'=>60,  'estatus'=>3, 'icon'=>'images/iconos/semaforo/estatus-3.png'],
            ['min'=>61, 'max'=>80,  'estatus'=>4, 'icon'=>'images/iconos/semaforo/estatus-4.png'],
            ['min'=>81, 'max'=>100, 'estatus'=>5, 'icon'=>'images/iconos/semaforo/estatus-5.png'],
        ];

        $this->tiempo = $tiempo==0 ? 1 : $tiempo;
        $this->avance = $avance;
    }

    public function getPorcentaje()
    {
        return $this->porc;
    }

    public function icono()
    {        
        $this->porc = round(($this->avance/$this->tiempo)) * 100;

        $icono = "";

        foreach ($this->rangos as $rango) {
            if ($this->porc>=$rango['min'] && $this->porc<=$rango['max']) {
                $icono = $rango['icon'];
            }
        }

        return $icono;
    }
}
