<?php 
namespace App\Libraries\Proyecto\Seguimiento;

use Carbon\{Carbon, CarbonInterval};
use DateTime;
use DateTimeZone;

class VigenciaAccion implements ISemaforo
{
    protected $ini;
    protected $fin;
    protected $rangos;
    protected $porc;
    
    public function __construct($ini, $fin)
    {
        $this->ini = new Carbon(new DateTime($ini), new DateTimeZone('America/Mexico_City'));
        $this->fin = new Carbon(new DateTime($fin), new DateTimeZone('America/Mexico_City'));
        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour'   => [60, 'minutes'],
            'day'    => [10, 'hours'],
            'week'   => [5, 'days'],            
        ]);
        
        $this->rangos = [
            ['min'=>0,  'max'=>20,  'estatus'=>1, 'icon'=>'images/iconos/semaforo/clock-1.png'],
            ['min'=>21, 'max'=>40,  'estatus'=>2, 'icon'=>'images/iconos/semaforo/clock-2.png'],
            ['min'=>41, 'max'=>60,  'estatus'=>3, 'icon'=>'images/iconos/semaforo/clock-3.png'],
            ['min'=>61, 'max'=>80,  'estatus'=>4, 'icon'=>'images/iconos/semaforo/clock-4.png'],
            ['min'=>81, 'max'=>100, 'estatus'=>5, 'icon'=>'images/iconos/semaforo/clock-5.png'],
        ];
    }

    public function getPorcentaje()
    {
        return $this->porc;
    }

    public function getTope()
    {                        
        $horas = $this->ini->diffFiltered(CarbonInterval::hour(), function (Carbon $date) {
            return $date->isWeekday() && $date->hour>=8 && $date->hour<18;
        }, $this->fin);
        
        return CarbonInterval::hours($horas)->totalDays ?? 1;
      
    }

    public function diasTranscurridos()
    {
        $horas = $this->ini->diffFiltered(CarbonInterval::hour(), function (Carbon $date) {
            return $date->isWeekday() && $date->hour>=8 && $date->hour<18;
        }, new Carbon(new DateTime(date('Y-m-d H:i:s')), new DateTimeZone('America/Mexico_City')));
        
        return CarbonInterval::hours($horas)->totalDays ?? 0;
    }

    public function icono()
    {
        $tope = $this->getTope();
        $dias = $this->diasTranscurridos();

        if ($dias>=$tope) {
            return $this->rangos[4]['icon'];
        }

        $this->porc = round(($dias*100/$tope));

        $icono = "";

        foreach ($this->rangos as $rango) {
            if ($this->porc>=$rango['min'] && $this->porc<=$rango['max']) {
                $icono = $rango['icon'];
            }
        }

        return $icono;
    }

}
