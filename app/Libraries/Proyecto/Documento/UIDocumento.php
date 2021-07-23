<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\CProyecto;
use App\Models\CatalogoModel;
use App\Traits\CifradoTrait;

class UIDocumento
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
        $this->catalogoModel = new CatalogoModel(); 
        $this->proyecto = $proyecto;      
        $this->config = $config;

        isset($config['entrada']) ? $this->formatearEntrada($config['entrada']) : null;
    }

    public function listado($datos, $id=null, $campo='descripcion')
    {
        $listado = "";

        foreach ($datos as $value) {
            $selected = $id==$value['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%s' %s>%s</option>", $value['id'], $selected, $value[$campo]);
        }
        return $listado;
    }

    public function getCatalogo($tabla='cat_tipo_documento', $campos='*')
    {
        return $this->catalogoModel->getCatalogo($tabla, $campos, 1);
    }

    public function formatearEntrada($entrada)
    {
        $entradas = explode(' ', $entrada);

        $cadena = [];
        
        foreach ($entradas as $val) {
            if (in_array($val, ['de','con', 'y', 'e', 'o', 'u'])) {
                continue;
            }
            $cadena[] = $val;
        }

        $this->config['cadena'] = count($cadena)>0 ? implode('|', $cadena) : '';
    }

    public function busqueda()
    {
        return isset($this->config['cadena']) ? $this->config['cadena'] : '';
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
