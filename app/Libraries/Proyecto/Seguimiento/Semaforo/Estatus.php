<?php 
namespace App\Libraries\Proyecto\Seguimiento\Semaforo;

class Estatus implements Indicador
{
    protected $leyenda;
    protected $tiempo;
    protected $avance;
    protected $rangos;
    protected $porc;
    
    public function __construct($tiempo, $avance)
    {
        $this->rangos = [
            ['min'=>0,  'max'=>20,  'estatus'=>1, 'icon'=>'images/iconos/semaforo/estatus-1.png', 'alt'=>'Avance de la acción '],
            ['min'=>21, 'max'=>40,  'estatus'=>2, 'icon'=>'images/iconos/semaforo/estatus-2.png', 'alt'=>'Avance de la acción '],
            ['min'=>41, 'max'=>60,  'estatus'=>3, 'icon'=>'images/iconos/semaforo/estatus-3.png', 'alt'=>'Avance de la acción '],
            ['min'=>61, 'max'=>80,  'estatus'=>4, 'icon'=>'images/iconos/semaforo/estatus-4.png', 'alt'=>'Avance de la acción '],
            ['min'=>81, 'max'=>100, 'estatus'=>5, 'icon'=>'images/iconos/semaforo/estatus-5.png', 'alt'=>'Avance de la acción '],
        ];

        $this->rangos11 = [
            'tiempo'=>[
                ['min'=>0,  'max'=>10, 'estatus'=>2], ['min'=>11, 'max'=>20, 'estatus'=>2], ['min'=>21, 'max'=>30, 'estatus'=>3], ['min'=>31, 'max'=>40, 'estatus'=>4], ['min'=>41, 'max'=>50, 'estatus'=>4],
                ['min'=>51, 'max'=>60, 'estatus'=>5], ['min'=>61, 'max'=>70, 'estatus'=>5], ['min'=>71, 'max'=>80, 'estatus'=>5], ['min'=>81, 'max'=>90, 'estatus'=>5], ['min'=>91, 'max'=>100, 'estatus'=>5]
            ],
            'avance'=>[
                ['min'=>0,  'max'=>10, 'estatus'=>2], ['min'=>11, 'max'=>20, 'estatus'=>2], ['min'=>21, 'max'=>30, 'estatus'=>3], ['min'=>31, 'max'=>40, 'estatus'=>4], ['min'=>41, 'max'=>50, 'estatus'=>4],
                ['min'=>51, 'max'=>60, 'estatus'=>5], ['min'=>61, 'max'=>70, 'estatus'=>5], ['min'=>71, 'max'=>80, 'estatus'=>5], ['min'=>81, 'max'=>90, 'estatus'=>5], ['min'=>91, 'max'=>100, 'estatus'=>5]
            ]
        ];

        $this->tiempo = $tiempo==0 ? 1 : $tiempo;
        $this->avance = $avance;
        $this->leyenda = '';
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
                $this->setLeyenda($rango['alt']);
                $icono = $rango['icon'];
            }
        }

        return $icono;
    }

    public function setLeyenda($leyenda)
    {
        $this->leyenda = $leyenda;
    }


    public function getLeyenda()
    {
        return $this->leyenda;
    }
}
