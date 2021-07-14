<?php 
namespace App\Libraries\Proyecto\Seguimiento\Semaforo;

use App\Models\AvanceModel;

class Avance implements Indicador
{
    protected $accionId;
    protected $leyenda;
    protected $avance;
    protected $rangos;
    protected $porc;
    
    public function __construct($accionId)
    {
        $this->rangos = [
            ['min'=>0,  'max'=>20,  'estatus'=>1, 'icon'=>'images/iconos/semaforo/avance-1.png', 'alt'=>'Avance '],
            ['min'=>21, 'max'=>40,  'estatus'=>2, 'icon'=>'images/iconos/semaforo/avance-2.png', 'alt'=>'Avance '],
            ['min'=>41, 'max'=>60,  'estatus'=>3, 'icon'=>'images/iconos/semaforo/avance-3.png', 'alt'=>'Avance '],
            ['min'=>61, 'max'=>80,  'estatus'=>4, 'icon'=>'images/iconos/semaforo/avance-4.png', 'alt'=>'Avance '],
            ['min'=>81, 'max'=>100, 'estatus'=>5, 'icon'=>'images/iconos/semaforo/avance-5.png', 'alt'=>'Avance '],
        ];

        $this->accionId = $accionId;
        $this->leyenda = '';
    }

    public function getPorcentaje()
    {
        return $this->porc;
    }

    public function icono()
    {        
        $this->porc = $this->avanceActual($this->obtenerAvance());

        $icono = "";

        foreach ($this->rangos as $rango) {
            if ($this->porc>=$rango['min'] && $this->porc<=$rango['max']) {
                $this->setLeyenda($rango['alt'].$this->porc.'%');
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

    protected function obtenerAvance()
    {
        $avanceModel = new AvanceModel();

        return $avanceModel->where('accion_id', $this->accionId)->first() ?? [];
    }

    protected function avanceActual($avance)
    {
        if (!isset($avance['avance'])) {
            return 0;
        }

        return round($avance['validado']==1 ? $avance['avance'] : $avance['anterior']);
    }

}
