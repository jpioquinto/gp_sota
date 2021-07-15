<?php 
namespace App\Libraries\Proyecto\Multimedia;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;
use App\Models\ImagenModel;

class UIMedia
{    
    protected $encrypter; 
    protected $proyecto;
    protected $config;
    protected $count;
    protected $total;

    use CifradoTrait;

    public function __construct(CProyecto $proyecto, $config=[])
    {
        $this->encrypter = \Config\Services::encrypter();  
        $this->imagenModel = new ImagenModel(); 
        $this->proyecto = $proyecto;      
        $this->config = $config;
    }

    public function offset()
    {
        return $this->config['pagina'] * $this->config['paginacion'];   
    }

    public function limit()
    {
        return $this->config['paginacion'];
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
