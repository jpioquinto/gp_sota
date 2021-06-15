<?php

namespace App\Models;

use CodeIgniter\Model;

class AccionEspecificaModel extends Model
{
    protected $table      = 'gp_acciones_especificas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'accion_id','definicion', 'descripcion', 'estatus', 'avance', 'ponderacion', 'fecha_ini', 'fecha_fin', 'programa',
        'responsable_id', 'evidencia', 'meta', 'nota', 'creado_por', 'actualizado_el', 'actualizado_por'
    ];
}
