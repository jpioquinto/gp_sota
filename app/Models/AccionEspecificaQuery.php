<?php

namespace App\Models;

class AccionEspecificaQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listarAcciones($accionId=null, $estatus=1)
    {                
        $tablas = "gp_acciones_especificas e LEFT JOIN  gp_usuarios u ON(u.id=e.responsable_id) ";
        $tablas.= "LEFT JOIN gp_contactos con ON(con.usuario_id=u.id) ";
        $tablas.= "LEFT JOIN gp_unidades_responsables o ON(o.id=con.organizacion_id) ";
        $tablas.= "LEFT JOIN v_avance_actual aa ON(aa.accion_id=e.id) ";
        $tablas.= "LEFT JOIN gp_avance_acciones a ON(a.id=aa.id) ";

        $campos = "e.*, o.sigla, a.validado";

        $filtro = "e.estatus IN($estatus) ";
        $filtro.= is_numeric($accionId) ? "AND e.accion_id={$accionId}" : "";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE {$filtro} ORDER BY e.fecha_ini ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
