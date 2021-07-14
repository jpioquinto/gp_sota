<?php 
namespace App\Libraries\Proyecto\Seguimiento;

use App\Models\AvanceModel;

class AvanceAccion implements ISemaforo
{
    protected $accionId;
    protected $avance;
    protected $rangos;
    protected $porc;
    
    public function __construct($accionId)
    {
        $this->rangos = [
            ['min'=>0,  'max'=>20,  'estatus'=>1, 'icon'=>'images/iconos/semaforo/avance-1.png'],
            ['min'=>21, 'max'=>40,  'estatus'=>2, 'icon'=>'images/iconos/semaforo/avance-2.png'],
            ['min'=>41, 'max'=>60,  'estatus'=>3, 'icon'=>'images/iconos/semaforo/avance-3.png'],
            ['min'=>61, 'max'=>80,  'estatus'=>4, 'icon'=>'images/iconos/semaforo/avance-4.png'],
            ['min'=>81, 'max'=>100, 'estatus'=>5, 'icon'=>'images/iconos/semaforo/avance-5.png'],
        ];

        $this->accionId = $accionId;
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
                $icono = $rango['icon'];
            }
        }

        return $icono;
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
