<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuloModel extends Model
{
    protected $table      = 'gp_modulos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    #protected $allowedFields = ['tipo', 'email', 'contacto_id', 'estatus'];
    
}
