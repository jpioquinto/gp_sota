<?php

namespace App\Models;


class MunicipioModel
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();#\Config\Database::connect();
    }
    public function getMunicipiosEstado($idEstado, $campos='*')
    {
        
        $query   = $this->db->query("SELECT {$campos} FROM gp_municipios WHERE estado_id={$idEstado} ORDER BY municipio ASC");
        $this->db->close();
        return $query->getResultArray();
    }
}
