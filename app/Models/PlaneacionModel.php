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
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 
        'fecha_publicado', 'num_paginas', 'pais_id', 'grafico_id', 'inegi_grafico_id', 'institucion_id',
        'entidad_apf_id', 'entidad_r', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
