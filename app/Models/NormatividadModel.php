<?php

namespace App\Models;

use CodeIgniter\Model;

class NormatividadModel extends Model
{
    protected $table      = 'gp_normatividades';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'clasificacion_id', 
        'vigencia', 'vigencia_final', 'pais_id', 'idioma_id', 'grafico_id', 'inegi_grafico_id', 'institucion_id',
        'entidad_apf_id', 'armonizado', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
