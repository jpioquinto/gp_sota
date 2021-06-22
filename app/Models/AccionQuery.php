<?php

namespace App\Models;


class AccionQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function reasignarPonderaciones($id)
    {
        $query   = $this->db->query("SELECT * FROM reasignar_ponderaciones({$id})");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
