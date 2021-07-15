<?php

namespace App\Models;

use CodeIgniter\Model;

class CriticidadModel extends Model
{
    protected $table      = 'gp_criticidad';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    #protected $allowedFields = [];
}
