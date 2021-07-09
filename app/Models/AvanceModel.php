<?php

namespace App\Models;

use CodeIgniter\Model;

class AvanceModel extends Model
{
    protected $table      = 'gp_avance_acciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'avance', 'accion_id', 'estatus', 'creado_por'
    ];
}
