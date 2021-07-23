<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaPrensaModel extends Model
{
    protected $table      = 'gp_notas_prensa';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema', 'autor', 'autor2', 
        'pais_id', 'idioma_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'fecha_publicado', 'num_paginas',
        'entidad_apf_id', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica', 'redes',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
