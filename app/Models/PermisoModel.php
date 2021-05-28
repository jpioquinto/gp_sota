<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table      = 'gp_permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'perfil_id', 'modulo_id', 'estatus', 'usuario_id', 'acciones'
    ];
    
}
