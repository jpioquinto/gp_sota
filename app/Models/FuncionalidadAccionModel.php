<?php

namespace App\Models;

use CodeIgniter\Model;

class FuncionalidadAccionModel extends Model
{
    protected $table      = 'gp_funcionalidad_acciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
}
