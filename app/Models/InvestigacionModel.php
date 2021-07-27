<?php

namespace App\Models;

use CodeIgniter\Model;

class InvestigacionModel extends Model
{
    protected $table      = 'gp_investigaciones';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema', 'autor1', 'autor2', 'autor3', 'detalle_publicacion', 
        'pais_id', 'idioma_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'anio_publicado', 'num_paginas', 'clasificacion_id',
        'editorial', 'edicion', 'isbn', 'url', 'palabra_clave',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' di')->distinct();
        $builder->select("di.*, d.ruta, p.pais, i.idioma, d.seccion, cob.descripcion as cobertura, inst.descripcion as institucion, cla.descripcion as clasificacion, conj.descripcion as conjunto");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=di.id AND d.estatus=1 AND d.seccion='investigacion'",
            'left'
        );
        $builder->join('cat_paises p','di.pais_id=p.id', 'left');
        $builder->join('cat_idiomas i','di.idioma_id=i.id', 'left');
        $builder->join('cat_coberturas cob','di.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','di.institucion_id=inst.id', 'left');
        $builder->join('cat_conjunto_datos conj','di.conjunto_dato_id=conj.id', 'left');  
        $builder->join('cat_clasificacion_docs cla','di.clasificacion_id=cla.id', 'left');   
        $builder->where(['di.estatus'=>$params['estatus'], 'di.proyecto_id'=>$params['proyectoId']]);        
        
        if ($busqueda) {
            $builder->where(
                "di.nombre ~* '{$busqueda}' OR di.alias ~* '{$busqueda}' OR di.formato ~* '{$busqueda}' OR di.palabra_clave ~* '{$busqueda}'   
                OR di.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR i.idioma ~* '{$busqueda}' OR di.lugar_aplica ~* '{$busqueda}'    
                OR di.tema ~* '{$busqueda}' OR di.autor1 ~* '{$busqueda}' OR di.autor2 ~* '{$busqueda}' OR di.autor3 ~* '{$busqueda}'   
                OR di.detalle_publicacion ~* '{$busqueda}' OR di.editorial ~* '{$busqueda}' OR di.edicion ~* '{$busqueda}' OR di.isbn ~* '{$busqueda}'  
                OR cob.descripcion ~* '{$busqueda}' OR inst.descripcion ~* '{$busqueda}' OR cla.descripcion ~* '{$busqueda}'     
                OR conj.descripcion ~* '{$busqueda}'"
            );
        }  
        
        $builder->orderBy('di.nombre', 'ASC');

        $this->db->close();
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }        

        return $builder->get()->getResultArray();
    }    
}
