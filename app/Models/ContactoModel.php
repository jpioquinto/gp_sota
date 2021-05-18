<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table      = 'gp_contactos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['nombre', 'ap_paterno', 'ap_materno','usuario_id', 'organizacion_id', 'estado_id', 'municipio_id', 'puesto_id', 'cargo', 'info_completa'];
    
}
