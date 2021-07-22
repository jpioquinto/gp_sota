<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaneacionModel extends Model
{
    protected $table      = 'gp_planeaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'nombre', 'alias', 'descripcion', 'tipo_id', 'palabra_clave', 'objetivo', 'cobertura_id', 'fecha_incorporacion', 'nota', 'organizacion_id',
        'coordinador_id', 'responsable_id', 'colaboradores','imagen', 'estatus', 'creado_por', 'actualizado_el', 'actualizado_por'
     ];
    
}
