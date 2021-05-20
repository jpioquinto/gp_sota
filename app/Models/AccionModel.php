<?php

namespace App\Models;

use CodeIgniter\Model;

class AccionModel extends Model
{
    protected $table      = 'gp_acciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
}
