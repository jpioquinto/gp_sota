<?php

namespace App\Models;


class PerfilQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listarPerfiles()
    {
        $campos = "p.*, u.nickname";

        $tablas = "gp_perfiles p LEFT JOIN gp_usuarios u ON(p.creado_por=u.id) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE p.estatus!=0 ORDER BY p.id ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
