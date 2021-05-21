<?php

namespace App\Models;


class UsuarioQuery
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listarUsuarios($usuarioId, $organizacionId=null)
    {
        $filtro = is_numeric($organizacionId) ? " AND con.organizacion_id={$organizacionId}" : "";

        $campos = "u.id, edo.entidad, u.nickname, p.nombre AS perfil, u.estatus, u.creado_el,";
        $campos.= "u.ultimo_acceso, c.nickname";

        $tablas = "gp_usuarios u LEFT JOIN gp_contactos con ON(u.id=con.usuario_id {$filtro}) ";
        $tablas.= "LEFT JOIN gp_estados edo ON(edo.id=con.estado_id) ";
        $tablas.= "LEFT JOIN gp_usuarios c ON(c.id=u.creadpo_por) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE u.id!={$usuarioId} ORDER BY edo.entidad ASC, u.nickname ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }

    public function obtenerPermisosModulos($perfilId)
    {        
        $campos = "m.id, m.nombre, m.controlador, m.icono, m.clase, m.orden, m.nodo_padre, p.acciones";
        
        $tablas = "gp_permisos p LEFT JOIN gp_modulos m ON(m.id=p.modulo_id AND p.estatus=1) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE m.estatus=1 AND p.perfil_id={$perfilId} ORDER BY m.nodo_padre ASC, m.orden ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
