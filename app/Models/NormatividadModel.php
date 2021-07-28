<?php

namespace App\Models;

use CodeIgniter\Model;

class NormatividadModel extends Model
{
    protected $table      = 'gp_normatividades';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'clasificacion_id', 
        'vigencia', 'vigencia_final', 'pais_id', 'idioma_id', 'grafico_id', 'inegi_grafico_id', 'institucion_id',
        'entidad_apf_id', 'armonizado', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
     ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' dn')->distinct();
        $builder->select("dn.*, d.ruta, p.pais, i.idioma, d.seccion, cob.descripcion as cobertura, inst.descripcion as institucion, apf.descripcion as entidad_apf, t.descripcion as tipo, cla.descripcion as clasificacion");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=dn.id AND d.estatus=1 AND d.seccion='normatividad'",
            'left'
        );
        $builder->join('cat_paises p','dn.pais_id=p.id', 'left');
        $builder->join('cat_idiomas i','dn.idioma_id=i.id', 'left');
        $builder->join('cat_coberturas cob','dn.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','dn.institucion_id=inst.id', 'left');  
        $builder->join('cat_entidades_apf apf','dn.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','dn.tipo_id=t.id', 'left'); 
        $builder->join('cat_clasificacion_docs cla','dn.clasificacion_id=cla.id', 'left'); 
        $builder->where(['dn.estatus'=>$params['estatus'], 'dn.proyecto_id'=>$params['proyectoId']]);  
        
        if (isset($params['id'])) {
            $builder->where('dn.id', $params['id']);
        }
        
        if ($busqueda) {
            $builder->where(
                "dn.nombre ~* '{$busqueda}' OR dn.alias ~* '{$busqueda}' OR dn.formato ~* '{$busqueda}' OR dn.palabra_clave ~* '{$busqueda}'   
                OR dn.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR i.idioma ~* '{$busqueda}' OR dn.lugar_aplica ~* '{$busqueda}' 
                OR dn.tema1 ~* '{$busqueda}' OR cob.descripcion ~* '{$busqueda}' OR inst.descripcion ~* '{$busqueda}' OR apf.descripcion ~* '{$busqueda}'  
                OR t.descripcion ~* '{$busqueda}' OR cla.descripcion ~* '{$busqueda}'"
            );
        }  
        
        $builder->orderBy('dn.nombre', 'ASC');

        $this->db->close();
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }        

        return $builder->get()->getResultArray();
    }    
}
