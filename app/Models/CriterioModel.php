<?php

namespace App\Models;

use CodeIgniter\Model;

class CriterioModel extends Model
{
    protected $table      = 'cat_criterios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['descripcion', 'icono', 'estatus', 'orden'];
    
}
