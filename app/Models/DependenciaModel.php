<?php

namespace App\Models;

use CodeIgniter\Model;

class DependenciaModel extends Model
{
    protected $table      = 'gp_organizaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    #protected $allowedFields = ['tipo', 'email', 'contacto_id', 'estatus'];
    
}
