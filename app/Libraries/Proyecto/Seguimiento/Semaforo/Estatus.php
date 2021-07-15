<?php 
namespace App\Libraries\Proyecto\Seguimiento\Semaforo;



class Estatus implements Indicador
{
    protected $criticidad;
    protected $leyenda;
    protected $tiempo;
    protected $avance;
    protected $rangos;
    protected $estatus;
    protected $porc;
    
    public function __construct($tiempo, $avance, $criticidad)
    {
        $this->estatus = [
            1=>['icon'=>'images/iconos/semaforo/estatus-1.png', 'alt'=>'Avance de la acción Excelente'],
            2=>['icon'=>'images/iconos/semaforo/estatus-2.png', 'alt'=>'Avance de la acción Bueno'],
            3=>['icon'=>'images/iconos/semaforo/estatus-3.png', 'alt'=>'Avance de la acción Regular'],
            4=>['icon'=>'images/iconos/semaforo/estatus-4.png', 'alt'=>'Avance de la acción Malo'],
            5=>['icon'=>'images/iconos/semaforo/estatus-5.png', 'alt'=>'Avance de la acción Crítico'],
        ];

        $this->rangos = [
            ['min'=>0,  'max'=>10], ['min'=>11, 'max'=>20], ['min'=>21, 'max'=>30],['min'=>31, 'max'=>40], ['min'=>41, 'max'=>50],
            ['min'=>51,  'max'=>60], ['min'=>61, 'max'=>70], ['min'=>71, 'max'=>80],['min'=>81, 'max'=>90], ['min'=>91, 'max'=>100],
        ];


        $this->tiempo = $tiempo==0 ? 1 : $tiempo;
        $this->criticidad = $criticidad;
        $this->avance = $avance;
        $this->leyenda = '';
        $this->porc = 0;
    }

    public function getTiempo()
    {
        return $this->tiempo;
    }

    public function getAvance()
    {
        return $this->avance;
    }

    public function getPorcentaje()
    {
        return $this->porc;
    }

    public function setLeyenda($leyenda)
    {
        $this->leyenda = $leyenda;
    }

    public function getLeyenda()
    {
        return $this->leyenda;
    }

    public function icono()
    {   
        $icono = "";

        if ($this->obtenNombreColumna()=='' || !is_numeric($this->posicionAvance())) {
            return $icono;
        }     

        $estatus = isset($this->criticidad[$this->posicionAvance()][$this->obtenNombreColumna()])
                ? $this->criticidad[$this->posicionAvance()][$this->obtenNombreColumna()] : null;

        if (!is_numeric($estatus) || !isset($this->estatus[$estatus]['icon'])) {
            return $icono;
        }

        $this->setLeyenda($this->estatus[$estatus]['alt']);

        return $this->estatus[$estatus]['icon'];
    }
    
    protected function obtenNombreColumna()
    {
        $columna = '';
        foreach ($this->rangos as $rango) {
            if ($this->getTiempo()>=$rango['min'] && $this->getTiempo()<=$rango['max']) {
                $columna = "_{$rango['min']}_{$rango['max']}";
            }
        }

        return $columna;
    }

    protected function posicionAvance()
    {
        $indice = null;
        foreach ($this->rangos as $key => $rango) {
            if ($this->getAvance()>=$rango['min'] && $this->getAvance()<=$rango['max']) {
                $indice = $key; break;
            }
        }

        return $indice;
    }
}
