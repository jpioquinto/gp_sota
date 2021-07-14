<?php 
namespace App\Libraries\Proyecto\Seguimiento\Semaforo;

interface Indicador
{
    public function setLeyenda($leyenda);
    public function getPorcentaje();
    public function getLeyenda();
    public function icono();
}
