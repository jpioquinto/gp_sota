<?php

namespace App\Models;

use CodeIgniter\Model;

class ReunionModel extends Model
{
    protected $table      = 'gp_reuniones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'autor', 'fecha_publicado',
        'pais_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'num_paginas', 
        'entidad_apf_id', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
