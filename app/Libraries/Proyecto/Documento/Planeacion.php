<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\PlaneacionModel;

class Planeacion extends Documento
{
    const SECCION = "planeacion";

    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($datos, $archivo)
    {   
        $validacion = $this->validacion->esSolicitudPlaneacionValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $carga = self::getInstanciaCarga($this->proyecto, self::SECCION);

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
        }

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),
            'cobertura_id'=>$datos['cobertura'],
            'proyecto_id'=>$this->proyecto->getId(),
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),
            'fecha_publicado'=>$datos['publicado'],
            'num_paginas'=>trim($datos['paginas']),
            'pais_id'=>$datos['pais'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>str_replace(',', ' ', $datos['clave']),
            'creado_por'=>$this->usuario->getId()
        ];

        $campos['nombre']  =$carga->verificaDuplicados( limpiarCadena($datos['nombre']) . '.' . $campos['formato']);

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['inegi']) && trim($datos['inegi'])!='') {
            $campos['inegi_grafico_id'] = trim($datos['inegi']);
        }

        if (isset($datos['entidad_r']) && trim($datos['entidad_r'])!='') {
            $campos['entidad_r'] = trim($datos['entidad_r']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }
        
        $mover = $carga->mover($archivo, quitaExtension($campos['nombre'])); 
        
        if (!$mover['Solicitud']) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar el documento '.$datos['nombre'] ];
        }

        $planeacionModel = new PlaneacionModel();
        
        if (!($id = $planeacionModel->insert($campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar registrar la carga del documento.'];
        }                 

        $this->guardarEvidencia([            
            'ruta'=>$carga->getDirectorio().$campos['nombre'],
            'proyecto_id'=> $campos['proyecto_id'],
            'creado_por'=>$this->usuario->getId(),
            'descripcion'=>$campos['descripcion'],
            'seccion'=> self::SECCION,
            'bloque'=>self::SECCION,
            'registro_id'=> $id,            
        ]);
        return ['Solicitud'=>true, 'Msg'=>'Documento cargado correctamente.'];
    }

    public function actualizar($datos)
    {   
        $validacion = $this->validacion->esSolicitudPlaneacionValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($datos);exit;

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),
            'cobertura_id'=>$datos['cobertura'],                        
            'fecha_publicado'=>$datos['publicado'],
            'num_paginas'=>trim($datos['paginas']),
            'pais_id'=>$datos['pais'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>implode(' ', $datos['clave']),
            'actualizado_el'=>'now()',
            'actualizado_por'=>$this->usuario->getId()
        ];

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['inegi']) && trim($datos['inegi'])!='') {
            $campos['grafico_inegi_id'] = trim($datos['inegi']);
        }

        if (isset($datos['entidad_r']) && trim($datos['entidad_r'])!='') {
            $campos['entidad_r'] = trim($datos['entidad_r']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }

        $planeacionModel = new PlaneacionModel();
        
        if (!($planeacionModel->update($this->desencriptar(base64_decode($datos['id'])), $campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar actualizar la Ficha del Documento.'];
        }                 

        return ['Solicitud'=>true, 'Msg'=>'Ficha actualizada correctamente.'];
    }

    public function vistaForm($id=null)
    {
        $registro = [];
        if ($id) {
            $docModel = new PlaneacionModel();
            $registro =  $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($id))]);
            $registro =  isset($registro[0]['id']) ? $registro[0] : [];         
        }

        $datos = [                
            '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas(isset($registro['cobertura_id']) ? $registro['cobertura_id'] : null), 'nombre'=>isset($registro['nombre']) ? $registro['nombre'] : null, 'descripcion'=>isset($registro['descripcion']) ? $registro['descripcion'] : null,'alias'=>isset($registro['alias']) ? $registro['alias'] : null]),
            'instituciones'=>$this->opcionesInstituciones(isset($registro['institucion_id']) ? $registro['institucion_id'] : null),
            'entidadesAPF'=>$this->opcionesEntidadesAPF(isset($registro['entidad_apf_id']) ? $registro['entidad_apf_id'] : null),
            'tipos'=>$this->opcionesCategoriaProyecto(isset($registro['tipo_id']) ? $registro['tipo_id'] : null),
            'paises'=>$this->opcionesPaises(isset($registro['pais_id']) ? $registro['pais_id'] : null),
            'ficha'=>self::SECCION,
            'doc'=>$registro,
            'id'=>$id
        ];
        
        return view(
            'proyectos/documentos/parcial/_v_form_planeacion', 
            $datos
        );

    }
}
