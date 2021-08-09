<?php

namespace App\Models;

use CodeIgniter\Model;

class DependenciaModel extends Model
{
    protected $table      = 'gp_unidades_responsables';
    protected $primaryKey = 'id';

    protected $db;

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['nombre', 'sigla', 'carpeta', 'calle', 'ext', 'int', 'col', 'cp', 'estado_id', 'municipio_id', 'estatus', 'creado_por', 'actualizado_el', 'actualizado_por'];

    public function listarURs($id=null, $estatus=1)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' ur')->distinct();
        $builder->select("ur.*, m.municipio,e.estado");
        $builder->join('gp_municipios m', 'm.id=ur.municipio_id', 'left');
        $builder->join('gp_estados e', 'e.id=ur.estado_id', 'left');

        if (!is_null($estatus)) {
            $builder->where('ur.estatus', !is_array($estatus) ? explode(',', $estatus) : $estatus);
        }

        if (!is_null($id)) {
            $builder->where('ur.id', !is_array($id) ? explode(',', $id) : $id);
        }
        
        $builder->orderBy('ur.nombre', 'ASC');
        
        $this->db->close();

        return $builder->get()->getResultArray();
    }
    
}
