<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\EstadisticaModel;

class Estadistica extends Documento
{
    const SECCION = "estadistica";

    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($datos, $archivo)
    {
        $validacion = $this->validacion->esSolicitudEstadisticaValida($datos);

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
            'tema1'=>$datos['tema1'],
            'proyecto_id'=>$this->proyecto->getId(),
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),
            'pais_id'=>$datos['pais'],
            'unidad_id'=>$datos['unidad'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'anio_publicado'=>$datos['publicado'],
            'vigencia'=>$datos['vigencia'],
            'conjunto_dato_id'=>$datos['conjunto_datos'],            
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>str_replace(',', ' ', $datos['clave']),
            'creado_por'=>$this->usuario->getId()
        ];

        $campos['nombre']  =$carga->verificaDuplicados( limpiarCadena($datos['nombre']) . '.' . $campos['formato']);

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['tema2']) && trim($datos['tema2'])!='') {
            $campos['tema2'] = trim($datos['tema2']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['notas']) && trim($datos['notas'])!='') {
            $campos['notas'] = trim($datos['notas']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }
        
        $mover = $carga->mover($archivo, quitaExtension($campos['nombre'])); 
        
        if (!$mover['Solicitud']) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar el documento '.$datos['nombre'] ];
        }

        $estadisticaModel = new EstadisticaModel();
        
        if (!($id = $estadisticaModel->insert($campos))) {
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
        $validacion = $this->validacion->esSolicitudEstadisticaValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),
            'cobertura_id'=>$datos['cobertura'],
            'tema1'=>$datos['tema1'],
            'pais_id'=>$datos['pais'],
            'unidad_id'=>$datos['unidad'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'anio_publicado'=>$datos['publicado'],
            'vigencia'=>$datos['vigencia'],
            'conjunto_dato_id'=>$datos['conjunto_datos'],            
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>implode(' ', $datos['clave']),
            'actualizado_el'=>'now()',
            'actualizado_por'=>$this->usuario->getId()
        ];

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['tema2']) && trim($datos['tema2'])!='') {
            $campos['tema2'] = trim($datos['tema2']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['notas']) && trim($datos['notas'])!='') {
            $campos['notas'] = trim($datos['notas']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }

        $estadisticaModel = new EstadisticaModel();
        
        if (!($estadisticaModel->update($this->desencriptar(base64_decode($datos['id'])), $campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar actualizar la Ficha del Documento.'];
        }                 

        return ['Solicitud'=>true, 'Msg'=>'Ficha actualizada correctamente.'];
    }

    public function vistaForm($id=null)
    {
        $registro = [];
        if ($id) {
            $docModel = new EstadisticaModel();
            $registro =  $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($id))]);
            $registro =  isset($registro[0]['id']) ? $registro[0] : [];         
        }

        $datos = [
            '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(), 'conjuntoDatos'=>$this->opcionesConjuntoDatos()]),
            '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas(), 'nombre'=>isset($registro['nombre']) ? $registro['nombre'] : null, 'descripcion'=>isset($registro['descripcion']) ? $registro['descripcion'] : null,'alias'=>isset($registro['alias']) ? $registro['alias'] : null]),
            'entidadesAPF'=>$this->opcionesEntidadesAPF(isset($registro['entidad_apf_id']) ? $registro['entidad_apf_id'] : null),
            'tipos'=>$this->opcionesCategoriaProyecto(isset($registro['tipo_id']) ? $registro['tipo_id'] : null), 
            'unidades'=>$this->opcionesUnidades(isset($registro['unidad_id']) ? $registro['unidad_id'] : null),
            'paises'=>$this->opcionesPaises(isset($registro['pais_id']) ? $registro['pais_id'] : null),
            'ficha'=>self::SECCION,
            'doc'=>$registro,
            'id'=>$id
        ];

        return view(
            'proyectos/documentos/parcial/_v_form_estadistica', 
            $datos
        );

    }
}
