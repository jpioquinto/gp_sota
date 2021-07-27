<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaneacionModel extends Model
{
    protected $table      = 'gp_planeaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 
        'fecha_publicado', 'num_paginas', 'pais_id', 'grafico_id', 'inegi_grafico_id', 'institucion_id',
        'entidad_apf_id', 'entidad_r', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' dp')->distinct();
        $builder->select("dp.*, d.ruta, p.pais, d.seccion, cob.descripcion as cobertura, inst.descripcion as institucion, apf.descripcion as entidad_apf, t.descripcion as tipo");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=dp.id AND d.estatus=1 AND d.seccion='planeacion'",
            'left'
        );
        $builder->join('cat_paises p','dp.pais_id=p.id', 'left');     
        $builder->join('cat_coberturas cob','dp.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','dp.institucion_id=inst.id', 'left');  
        $builder->join('cat_entidades_apf apf','dp.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','dp.tipo_id=t.id', 'left');        
        $builder->where(['dp.estatus'=>$params['estatus'], 'dp.proyecto_id'=>$params['proyectoId']]);        
        
        if ($busqueda) {
            $builder->where(
                "dp.nombre ~* '{$busqueda}' OR dp.alias ~* '{$busqueda}' OR dp.formato ~* '{$busqueda}' OR dp.palabra_clave ~* '{$busqueda}'    
                OR dp.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR dp.lugar_aplica ~* '{$busqueda}' OR dp.entidad_r ~* '{$busqueda}'  
                OR cob.descripcion ~* '{$busqueda}' OR inst.descripcion ~* '{$busqueda}' OR apf.descripcion ~* '{$busqueda}' OR t.descripcion ~* '{$busqueda}'"
            );
        }  
        
        $builder->orderBy('dp.nombre', 'ASC');

        $this->db->close();
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }        

        return $builder->get()->getResultArray();
    }    
}
