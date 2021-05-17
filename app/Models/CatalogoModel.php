<?php

namespace App\Models;


class CatalogoModel
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();#\Config\Database::connect();
    }
    public function getCatalogo($tabla, $campos='*', $estatus=null)
    {
        $filtro  = $estatus ? "WHERE estatus={$estatus}" : ""; 
        $query   = $this->db->query("SELECT {$campos} FROM {$tabla} {$filtro}");
        $this->db->close();
        return $query->getResultArray();
    }
}
