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

        $campos = "u.id, edo.estado, u.nickname, p.nombre AS perfil, u.estatus, u.creado_el,";
        $campos.= "u.ultimo_acceso, c.nickname AS creador";

        $tablas = "gp_usuarios u LEFT JOIN gp_contactos con ON(u.id=con.usuario_id {$filtro}) ";
        $tablas.= "LEFT JOIN gp_estados edo ON(edo.id=con.estado_id) ";
        $tablas.= "LEFT JOIN gp_perfiles p ON(p.id=u.perfil_id) ";
        $tablas.= "LEFT JOIN gp_usuarios c ON(c.id=u.creado_por) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE u.id!={$usuarioId} ORDER BY edo.estado ASC, u.nickname ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }

    public function listarUsuariosOrganizacion($organizacionId, $usuarioId=null, $estatus=1)
    {
        $filtroUsuario = is_numeric($usuarioId) ? " AND u.id!=={$usuarioId}" : "";         
        $filtro = is_numeric($organizacionId) ? " AND con.organizacion_id={$organizacionId}" : "";

        $campos = "u.id, edo.estado, u.nickname, p.nombre AS perfil, u.estatus, u.creado_el,u.ultimo_acceso, c.nickname AS creador,";
        $campos.= "CONCAT(con.nombre, ' ', con.ap_paterno, ' ', con.ap_materno) as nombre";

        $tablas = "gp_usuarios u LEFT JOIN gp_contactos con ON(u.id=con.usuario_id {$filtro}) ";
        $tablas.= "LEFT JOIN gp_estados edo ON(edo.id=con.estado_id) ";
        $tablas.= "LEFT JOIN gp_perfiles p ON(p.id=u.perfil_id) ";
        $tablas.= "LEFT JOIN gp_usuarios c ON(c.id=u.creado_por) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE u.estatus IN({$estatus}) {$filtroUsuario} ORDER BY edo.estado ASC, u.nickname ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }

    public function obtenerPermisosModulos($perfilId)
    {        
        $campos = "m.id, m.nombre, m.controlador, m.icono, m.clase, m.orden, m.nodo_padre, m.descripcion, p.acciones";
        
        $tablas = "gp_permisos p LEFT JOIN gp_modulos m ON(m.id=p.modulo_id AND p.estatus=1) ";

        $query   = $this->db->query("SELECT {$campos} FROM {$tablas} WHERE m.estatus=1 AND p.perfil_id={$perfilId} ORDER BY m.nodo_padre ASC, m.orden ASC");
        
        $this->db->close();

        return $query->getResultArray();
    }
}
