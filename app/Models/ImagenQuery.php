<?php

namespace App\Models;


class ImagenQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $campos = "i.*";

        $tablas = "gp_imagenes i ";

        $filtro = "i.estatus IN({$params['estatus']}) AND i.proyecto_id={$params['proyectoId']}";

        $filtro .= $busqueda ? " AND (i.nombre ~* '{$busqueda}' OR i.autor ~* '{$busqueda}' OR i.formato ~* '{$busqueda}' OR i.palabra_clave ~* '{$busqueda}')" : '';

        $paginacion  = $offset ? "offset {$offset} " : "";
        $paginacion .= $limit ? "limit {$limit} " : "";#echo "SELECT {$campos} FROM {$tablas} WHERE {$filtro} ORDER BY v.nombre ASC {$paginacion}";exit;

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE {$filtro} ORDER BY i.nombre ASC {$paginacion}");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
