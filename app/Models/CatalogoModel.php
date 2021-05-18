<?php

namespace App\Models;


class CatalogoModel
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();#\Config\Database::connect();
    }
    public function getCatalogo($tabla, $campos='*', $estatus=null, $sFiltro=null)
    {
        $filtro  = $estatus ? "WHERE estatus={$estatus}" : ""; 
        
        if ($sFiltro) {
            $filtro  .= $filtro!="" ? " AND {$sFiltro}" : "WHERE {$sFiltro}";
        }
        #echo "SELECT {$campos} FROM {$tabla} {$filtro}";exit;
        $query   = $this->db->query($sql="SELECT {$campos} FROM {$tabla} {$filtro}");
        $this->db->close();
        return $query->getResultArray();
    }
}
