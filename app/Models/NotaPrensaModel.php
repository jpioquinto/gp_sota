<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaPrensaModel extends Model
{
    protected $table      = 'gp_notas_prensa';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema', 'autor', 'autor2', 
        'pais_id', 'idioma_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'fecha_publicado', 'num_paginas',
        'entidad_apf_id', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica', 'redes',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' dp')->distinct();
        $builder->select('dp.*, d.ruta, p.pais, i.idioma');
        $builder->join(
            'gp_documentos d',
            "d.registro_id=dp.id AND d.estatus=1 AND d.seccion='planeacion'",
            'left'
        );
        $builder->join('cat_paises p','dp.pais_id=p.id', 'left');
        $builder->join('cat_idiomas i','dp.idioma_id=i.id', 'left');
        $builder->join('cat_coberturas cob','dp.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','dp.institucion_id=inst.id', 'left');
        $builder->join('cat_conjunto_datos conj','dp.conjunto_dato_id=conj.id', 'left');  
        $builder->join('cat_entidades_apf apf','dp.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','dp.tipo_id=t.id', 'left'); 
        $builder->where(['dp.estatus'=>$params['estatus'], 'dp.proyecto_id'=>$params['proyectoId']]);        
        
        if ($busqueda) {
            $builder->where(
                "dp.nombre ~* '{$busqueda}' OR dp.alias ~* '{$busqueda}' OR dp.formato ~* '{$busqueda}' OR dp.palabra_clave ~* '{$busqueda}'   
                OR dp.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR i.idioma ~* '{$busqueda}' OR dp.lugar_aplica ~* '{$busqueda}' 
                OR dp.tema ~* '{$busqueda}' OR dp.autor ~* '{$busqueda}' OR dp.autor2 ~* '{$busqueda}' OR dp.redes ~* '{$busqueda}' 
                OR cob.descripcion ~* '{$busqueda}' OR inst.descripcion ~* '{$busqueda}' OR apf.descripcion ~* '{$busqueda}' 
                OR t.descripcion ~* '{$busqueda}' OR conj.descripcion ~* '{$busqueda}'"
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
