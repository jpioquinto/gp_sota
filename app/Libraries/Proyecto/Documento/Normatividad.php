<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\NormatividadModel;

class Normatividad extends Documento
{
    const FICHA = "normatividad";

    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($datos, $archivo)
    {
        $validacion = $this->validacion->esSolicitudNormatividadValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $carga = self::getInstanciaCarga($this->proyecto, self::FICHA);

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
        }

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),
            'cobertura_id'=>$datos['cobertura'],
            'proyecto_id'=>$this->proyecto->getId(),
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),
            'pais_id'=>$datos['pais'],
            'idioma_id'=>$datos['idioma'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'armonizado'=>$datos['armonizado'],
            'vigencia_final'=>$datos['vigencia_final'],
            'clasificacion_id'=>$datos['clasificacion'],
            'vigencia'=>$datos['vigencia'],
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

        $normatividadModel = new NormatividadModel();
        
        if (!($id = $normatividadModel->insert($campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar registrar la carga del documento.'];
        }                 

        $this->guardarEvidencia([            
            'ruta'=>$carga->getDirectorio().$campos['nombre'],
            'proyecto_id'=> $campos['proyecto_id'],
            'creado_por'=>$this->usuario->getId(),
            'descripcion'=>$campos['descripcion'],
            'ficha'=> self::FICHA,
            'bloque'=>self::FICHA,
            'registro_id'=> $id,            
        ]);
        return ['Solicitud'=>true, 'Msg'=>'Documento cargado correctamente.'];
    }

    public function actualizar($datos)
    {
        $validacion = $this->validacion->esSolicitudNormatividadValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),
            'cobertura_id'=>$datos['cobertura'],
            'pais_id'=>$datos['pais'],
            'idioma_id'=>$datos['idioma'],
            'tema1'=>$datos['tema1'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'i_concurrente'=>$datos['instrumento'],
            'armonizado'=>$datos['armonizado'],
            'vigencia_final'=>$datos['vigencia_final'],
            'clasificacion_id'=>$datos['clasificacion'],
            'vigencia'=>$datos['vigencia'],
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

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }
        
        $normatividadModel = new NormatividadModel();
        
        if (!($normatividadModel->update($this->desencriptar(base64_decode($datos['id'])), $campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar actualizar la Ficha del Documento.'];
        }
        
        $registro = $normatividadModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($datos['id']))]);

        return [
            'Solicitud'=>true, 
            'Msg'=>'Ficha actualizada correctamente.',
            'detalle'=> view("proyectos/documentos/parcial/_v_seccion_".self::FICHA.".php", isset($registro[0]['id']) ? $registro[0] : [])
        ];
    }

    public function eliminar($id)
    {
        $docModel = new NormatividadModel();
        
        $registro = $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$id]);

        if (!isset($registro[0]['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar recuperar información del documento.'];
        }

        if (!is_file($registro[0]['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el archivo físicamente.'];
        }

        if (!unlink($registro[0]['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar eliminar el documento.'];
        }

        return $docModel->update($id, ['estatus'=>0]) ? ['Solicitud'=>true, 'Msg'=>'Documento eliminado correctamente.'] : ['Solicitud'=>false, 'Error'=>'Error al intentar cambiar el estatus del documento.'];
    }

    public function vistaForm($id=null)
    {
        $registro = [];
        if ($id) {
            $docModel = new NormatividadModel();
            $registro =  $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($id))]);
            $registro =  isset($registro[0]['id']) ? $registro[0] : [];         
        }

        $datos = [                
            '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(), 'idiomas'=>$this->opcionesIdiomas()]),
            '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas(), 'nombre'=>isset($registro['nombre']) ? $registro['nombre'] : null, 'descripcion'=>isset($registro['descripcion']) ? $registro['descripcion'] : null,'alias'=>isset($registro['alias']) ? $registro['alias'] : null]),
            'clasificaciones'=>$this->opcionesClasificaciones(isset($registro['clasificacion_id']) ? $registro['clasificacion_id'] : null),                 
            'instituciones'=>$this->opcionesInstituciones(isset($registro['institucion_id']) ? $registro['institucion_id'] : null),
            'entidadesAPF'=>$this->opcionesEntidadesAPF(isset($registro['entidad_apf_id']) ? $registro['entidad_apf_id'] : null),
            'palabras'=>$this->opcionesPalabrasClave(!empty($registro['palabra_clave']) ? $registro['palabra_clave'] : ''),
            'tipos'=>$this->opcionesCategoriaProyecto(isset($registro['tipo_id']) ? $registro['tipo_id'] : null), 
            'ficha'=>self::FICHA,
            'doc'=>$registro,
            'id'=>$id
        ];

        return view(
            'proyectos/documentos/parcial/_v_form_normatividad',
            $datos
        );

    }
}
