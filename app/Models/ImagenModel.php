<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenModel extends Model
{
    protected $table      = 'gp_imagenes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'ruta', 'descripcion', 'autor', 'formato', 'palabra_clave',
        'resolucion', 'tamanio', 'p_serie', 'restriccion_id', 'creado_por', 'actualizado_el', 'actualizado_por',
        'eliminado_el', 'eliminado_por'
    ];
    
}
