<?php

namespace App\Models;

use CodeIgniter\Model;

class MunicipioModel extends Model
{
    protected $table      = 'gp_municipios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    public function getMunicipiosEstado($idEstado, $campos='*')
    {
        $this->db = db_connect();                
        $query   = $this->db->query("SELECT {$campos} FROM gp_municipios WHERE estado_id={$idEstado} ORDER BY municipio ASC");
        $this->db->close();
        return $query->getResultArray();
    }
}
