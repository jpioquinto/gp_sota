<?php

namespace App\Models;

use CodeIgniter\Model;

class InvestigacionModel extends Model
{
    protected $table      = 'gp_investigaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema', 'autor1', 'autor2', 'autor3', 'detalle_publicacion', 
        'pais_id', 'idioma_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'anio_publicado', 'num_paginas', 'clasificacion_id',
        'editorial', 'edicion', 'isbn', 'url', 'palabra_clave',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];
    
}
