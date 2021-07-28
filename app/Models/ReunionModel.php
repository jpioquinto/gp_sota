<?php

namespace App\Models;

use CodeIgniter\Model;

class ReunionModel extends Model
{
    protected $table      = 'gp_reuniones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'autor', 'fecha_publicado',
        'pais_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'num_paginas', 
        'entidad_apf_id', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' dr')->distinct();
        $builder->select("dr.*, d.ruta, p.pais, d.seccion, inst.descripcion as institucion, apf.descripcion as entidad_apf, t.descripcion as tipo, conj.descripcion as conjunto");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=dr.id AND d.estatus=1 AND d.seccion='reunion'",
            'left'
        );
        $builder->join('cat_paises p','dr.pais_id=p.id', 'left');
                
        $builder->join('cat_instituciones inst','dr.institucion_id=inst.id', 'left');
        $builder->join('cat_conjunto_datos conj','dr.conjunto_dato_id=conj.id', 'left');  
        $builder->join('cat_entidades_apf apf','dr.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','dr.tipo_id=t.id', 'left'); 
        
        $builder->where(['dr.estatus'=>$params['estatus'], 'dr.proyecto_id'=>$params['proyectoId']]); 
        
        if (isset($params['id'])) {
            $builder->where('dr.id', $params['id']);
        }
        
        if ($busqueda) {
            $builder->where(
                "dr.nombre ~* '{$busqueda}' OR dr.alias ~* '{$busqueda}' OR dr.formato ~* '{$busqueda}' OR dr.palabra_clave ~* '{$busqueda}'   
                OR dr.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR dr.lugar_aplica ~* '{$busqueda}' OR dr.autor ~* '{$busqueda}' 
                OR inst.descripcion ~* '{$busqueda}' OR apf.descripcion ~* '{$busqueda}' OR t.descripcion ~* '{$busqueda}' OR conj.descripcion ~* '{$busqueda}'"
            );
        }  
        
        $builder->orderBy('dr.nombre', 'ASC');

        $this->db->close();
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }        

        return $builder->get()->getResultArray();
    }    
}
