<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticaModel extends Model
{
    protected $table      = 'gp_estadisticas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $db;

    protected $allowedFields = [
        'proyecto_id', 'estatus', 'nombre', 'formato', 'alias', 'descripcion', 'cobertura_id', 'tema1', 'tema2', 
        'anio_publicado', 'vigencia', 'pais_id', 'grafico_id', 'institucion_id', 'conjunto_dato_id', 'unidad_id',
        'entidad_apf_id', 'i_concurrente', 'tipo_id', 'url', 'palabra_clave', 'lugar_aplica', 'notas',
        'creado_por', 'actualizado_el', 'actualizado_por', 'eliminado_el', 'eliminado_por'
    ];

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $this->db = db_connect();

        $builder = $this->db->table($this->table.' de')->distinct();
        $builder->select("de.*, d.ruta, p.pais, null as idioma, d.seccion, cob.descripcion as cobertura, inst.descripcion as institucion, apf.descripcion as entidad_apf, t.descripcion as tipo, conj.descripcion as conjunto, u.descripcion as unidad");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=de.id AND d.estatus=1 AND d.seccion='estadistica'",
            'left'
        );
        $builder->join('cat_paises p','de.pais_id=p.id', 'left');
        
        $builder->join('cat_coberturas cob','de.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','de.institucion_id=inst.id', 'left');
        $builder->join('cat_conjunto_datos conj','de.conjunto_dato_id=conj.id', 'left');  
        $builder->join('cat_entidades_apf apf','de.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','de.tipo_id=t.id', 'left'); 
        $builder->join('cat_unidades u','de.unidad_id=u.id', 'left');
        $builder->where(['de.estatus'=>$params['estatus'], 'de.proyecto_id'=>$params['proyectoId']]);        
        
        if ($busqueda) {
            $builder->where(
                "de.nombre ~* '{$busqueda}' OR de.alias ~* '{$busqueda}' OR de.formato ~* '{$busqueda}' OR de.palabra_clave ~* '{$busqueda}'   
                OR de.descripcion ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR de.lugar_aplica ~* '{$busqueda}' OR de.tema1 ~* '{$busqueda}' 
                OR de.tema2 ~* '{$busqueda}'  OR de.notas ~* '{$busqueda}' OR cob.descripcion ~* '{$busqueda}' OR inst.descripcion ~* '{$busqueda}'  
                OR apf.descripcion ~* '{$busqueda}' OR t.descripcion ~* '{$busqueda}' OR u.descripcion ~* '{$busqueda}' OR conj.descripcion ~* '{$busqueda}'"
            );
        }  
        
        $builder->orderBy('de.nombre', 'ASC');

        $this->db->close();
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }        

        return $builder->get()->getResultArray();
    }    
}
