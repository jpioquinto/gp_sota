<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'gp_usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'nickname', 'password', 'perfil_id', 'ultimo_acceso', 'creado_por',
        'estatus', 'archivo_cer', 'archivo_cer', 'pass_key'
    ];
    
}
