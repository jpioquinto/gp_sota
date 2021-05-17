<?php

namespace App\Models;

use CodeIgniter\Model;

class CorreoModel extends Model
{
    protected $table      = 'gp_correos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['tipo', 'email', 'contacto_id'];
    
}
