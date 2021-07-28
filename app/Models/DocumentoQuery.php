<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoQuery extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function listado($params, $busqueda=null, $offset=null, $limit=null)
    {
        $builder = $this->db->table('v_fichas_documentos vd')->distinct();
        $builder->select("vd.*, d.ruta, p.pais, i.idioma, cob.descripcion as cobertura, inst.descripcion as institucion, apf.descripcion as entidad_apf, t.descripcion as tipo, conj.descripcion as conjunto, u.descripcion as unidad, cla.descripcion as clasificacion");
        $builder->join(
            'gp_documentos d',
            "d.registro_id=vd.id AND d.estatus=1 AND vd.seccion=d.seccion",
            'left'
        );
        $builder->join('cat_paises p','vd.pais_id=p.id', 'left');
        $builder->join('cat_idiomas i','vd.idioma_id=i.id', 'left');

        $builder->join('cat_coberturas cob','vd.cobertura_id=cob.id', 'left'); 
        $builder->join('cat_instituciones inst','vd.institucion_id=inst.id', 'left');
        $builder->join('cat_conjunto_datos conj','vd.conjunto_dato_id=conj.id', 'left');  
        $builder->join('cat_entidades_apf apf','vd.entidad_apf_id=apf.id', 'left');   
        $builder->join('cat_categorias t','vd.tipo_id=t.id', 'left'); 
        $builder->join('cat_clasificacion_docs cla','vd.clasificacion_id=cla.id', 'left');  
        $builder->join('cat_unidades u','vd.unidad_id=u.id', 'left');

        $builder->where(['vd.estatus'=>$params['estatus'], 'vd.proyecto_id'=>$params['proyectoId']]);
        $builder->whereIn('d.seccion',['planeacion', 'normatividad', 'estadistica', 'nota-prensa', 'reunion', 'investigacion']);
        
        if ($busqueda) {
            $builder->where(
                "vd.nombre ~* '{$busqueda}' OR vd.alias ~* '{$busqueda}' OR vd.formato ~* '{$busqueda}' OR vd.palabra_clave ~* '{$busqueda}'   
                OR vd.descripcion ~* '{$busqueda}' OR vd.autor ~* '{$busqueda}' OR vd.autor1 ~* '{$busqueda}' OR vd.autor2 ~* '{$busqueda}' 
                OR vd.autor3 ~* '{$busqueda}' OR vd.tema ~* '{$busqueda}' OR vd.tema1 ~* '{$busqueda}' OR vd.tema2 ~* '{$busqueda}'  
                OR vd.notas ~* '{$busqueda}' OR vd.editorial ~* '{$busqueda}'  OR vd.edicion ~* '{$busqueda}'  OR vd.isbn ~* '{$busqueda}' 
                OR vd.redes ~* '{$busqueda}' OR p.pais ~* '{$busqueda}' OR i.idioma ~* '{$busqueda}' OR vd.lugar_aplica ~* '{$busqueda}'"
            );
        }#return $builder->getCompiledSelect();  
        
        $builder->orderBy('vd.nombre', 'ASC');
        
        if (!is_null($limit) && !is_null($offset)) {
            return $builder->get($limit, $offset)->getResultArray();
        }

        $this->db->close();

        return $builder->get()->getResultArray();
    }
}
