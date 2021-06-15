<?php

namespace App\Models;

use CodeIgniter\Model;

class AccionGeneralModel extends Model
{
    protected $table      = 'gp_acciones_generales';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id','definicion', 'descripcion', 'estatus', 'orden', 'ponderacion',
        'coordinador_id', 'nota', 'creado_por', 'actualizado_el', 'actualizado_por'
    ];
}
