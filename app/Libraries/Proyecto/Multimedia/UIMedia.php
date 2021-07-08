<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;
use App\Models\ImagenModel;

class UIMedia
{    
    protected $encrypter; 
    protected $proyecto;
    protected $count;
    protected $total;

    use CifradoTrait;

    public function __construct(CProyecto $proyecto)
    {
        $this->encrypter = \Config\Services::encrypter();  
        $this->imagenModel = new ImagenModel(); 
        $this->proyecto = $proyecto;      
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }        
}
