<?php

namespace App\Models;

use CodeIgniter\Model;

class SubModuloModel extends Model
{
    protected $table      = 'gp_submodulos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['nombre','descripcion', 'icono', 'estatus', 'orden', 'controlador'];
    
}
