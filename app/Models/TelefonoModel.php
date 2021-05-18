<?php

namespace App\Models;

use CodeIgniter\Model;

class TelefonoModel extends Model
{
    protected $table      = 'gp_telefonos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['tipo', 'lada', 'telefono', 'extension', 'contacto_id', 'estatus'];
    
}
