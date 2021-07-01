<?php

namespace App\Models;

use CodeIgniter\Model;

class EvidenciaModel extends Model
{
    protected $table      = 'gp_documentos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['proyecto_id', 'registro_id', 'seccion', 'estatus', 'ruta', 'descripcion', 'creado_por', 'eliminado_el', 'eliminado_por'];
}
