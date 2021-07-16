<?php

namespace App\Models;


class VideoQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $campos = "v.*";

        $tablas = "gp_videos v ";

        $filtro = "v.estatus IN({$params['estatus']}) AND v.proyecto_id={$params['proyectoId']}";

        $filtro .= $busqueda ? " AND (v.nombre ~* '{$busqueda}' OR v.autor ~* '{$busqueda}' OR v.formato ~* '{$busqueda}' OR v.palabra_clave ~* '{$busqueda}')" : '';

        $paginacion  = $offset ? "offset {$offset} " : "";
        $paginacion .= $limit ? "limit {$limit} " : "";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE {$filtro} ORDER BY v.nombre ASC {$paginacion}");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
