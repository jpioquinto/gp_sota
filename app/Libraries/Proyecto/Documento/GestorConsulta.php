<?php 
namespace App\Libraries\Proyecto\Documento;
use CodeIgniter\Model;

class GestorConsulta
{    
    protected $modelo;
    
    public function __construct(Model $modelo)
    {             
        $this->modelo = $modelo;
    }

    public function listado($params, $busqueda=null, $offset=null, $limit=null){
        return $this->modelo->listado($params, $busqueda, $offset, $limit);
    }
}
