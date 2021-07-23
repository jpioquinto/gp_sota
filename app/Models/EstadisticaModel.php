<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticaModel extends Model
{
    protected $table      = 'gp_estadisticas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema1', 'tema2', 
        'anio_publicado', 'vigencia', 'pais_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'unidad_id',
        'entidad_apf_id', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica', 'notas',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
