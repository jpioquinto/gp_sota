<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'gp_usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'nickname', 'password', 'perfil_id', 'ultimo_acceso', 'creado_por',
        'estatus', 'archivo_cer', 'archivo_cer', 'pass_key'
    ];

    public function obtenerUsuario($nickname)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' u')->distinct();
        $builder->select("u.*, concat(c.nombre,' ',c.ap_paterno) as nombre_completo");
        $builder->join(
            'gp_contactos c',
            "c.usuario_id=u.id",
            'left'
        );

        $builder->where(['u.nickname'=>$nickname]); 
        
        $this->db->close();

        return $builder->get()->getResultArray();
    }
    
}
