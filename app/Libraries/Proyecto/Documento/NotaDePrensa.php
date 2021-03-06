<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\NotaPrensaModel;

class NotaDePrensa extends Documento
{
    const FICHA = "nota-prensa";

    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($datos, $archivo)
    {
        $validacion = $this->validacion->esSolicitudNotaPrensaValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $carga = self::getInstanciaCarga($this->proyecto, self::FICHA);

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontrĂ³ el directorio: '.$carga->getDirectorio()];
        }

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),            
            'proyecto_id'=>$this->proyecto->getId(),
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),
            'pais_id'=>$datos['pais'],
            'idioma_id'=>$datos['idioma'],
            'autor'=>$datos['autor'],
            'tema'=>$datos['tema'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'cobertura_id'=>$datos['cobertura'],
            'fecha_publicado'=>$datos['publicado'],
            'num_paginas'=>$datos['paginas'],
            'conjunto_dato_id'=>$datos['conjunto_datos'],            
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>str_replace(',', ' ', $datos['clave']),
            'creado_por'=>$this->usuario->getId()
        ];

        $campos['nombre']  =$carga->verificaDuplicados( limpiarCadena($datos['nombre']) . '.' . $campos['formato']);

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['autor2']) && trim($datos['autor2'])!='') {
            $campos['autor2'] = trim($datos['autor2']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }

        if (isset($datos['redes']) && trim($datos['redes'])!='') {
            $campos['redes'] = str_replace(',', ' ', $datos['redes']);
        }
        
        $mover = $carga->mover($archivo, quitaExtension($campos['nombre'])); 
        
        if (!$mover['Solicitud']) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar el documento '.$datos['nombre'] ];
        }

        $notaModel = new NotaPrensaModel();
        
        if (!($id = $notaModel->insert($campos))) {
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
        $validacion = $this->validacion->esSolicitudNotaPrensaValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),            
            'pais_id'=>$datos['pais'],
            'idioma_id'=>$datos['idioma'],
            'autor'=>$datos['autor'],
            'tema'=>$datos['tema'],
            'institucion_id'=>$datos['institucion'],
            'entidad_apf_id'=>$datos['entidad_apf'],
            'cobertura_id'=>$datos['cobertura'],
            'fecha_publicado'=>$datos['publicado'],
            'num_paginas'=>$datos['paginas'],
            'conjunto_dato_id'=>$datos['conjunto_datos'],            
            'tipo_id'=>$datos['tipo'],
            'palabra_clave'=>implode(' ', $datos['clave']),
            'actualizado_el'=>'now()',
            'actualizado_por'=>$this->usuario->getId()
        ];

        if (isset($datos['grafico']) && trim($datos['grafico'])!='') {
            $campos['grafico_id'] = trim($datos['grafico']);
        }

        if (isset($datos['autor2']) && trim($datos['autor2'])!='') {
            $campos['autor2'] = trim($datos['autor2']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }

        if (isset($datos['lugar']) && trim($datos['lugar'])!='') {
            $campos['lugar_aplica'] = trim($datos['lugar']);
        }

        if (isset($datos['redes']) && count($datos['redes'])>0) {
            $campos['redes'] = implode(' ', $datos['redes']);
        }
        
        $notaModel = new NotaPrensaModel();
        
        if (!($id = $notaModel->update($this->desencriptar(base64_decode($datos['id'])), $campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar actualizar la Ficha del Documento.'];
        }
        
        $registro = $notaModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($datos['id']))]);

        return [
            'Solicitud'=>true, 
            'Msg'=>'Ficha actualizada correctamente.',
            'detalle'=> view("proyectos/documentos/parcial/_v_seccion_".self::FICHA.".php", isset($registro[0]['id']) ? $registro[0] : [])
        ];
    }

    public function eliminar($id)
    {
        $docModel = new NotaPrensaModel();
        
        $registro = $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$id]);

        if (!isset($registro[0]['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar recuperar informaciĂ³n del documento.'];
        }

        if (!is_file($registro[0]['ruta'])) {
            return ['Solicitud'=>false, 'Error'=>'No se encontrĂ³ el archivo fĂ­sicamente.'];
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
            $docModel = new NotaPrensaModel();
            $registro =  $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($id))]);
            $registro =  isset($registro[0]['id']) ? $registro[0] : [];         
        }
        
        $datos = [
            '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(isset($registro['institucion_id']) ? $registro['institucion_id'] : null), 'conjuntoDatos'=>$this->opcionesConjuntoDatos(isset($registro['conjunto_dato_id']) ? $registro['conjunto_dato_id'] : null)]),
            '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(isset($registro['pais_id']) ? $registro['pais_id'] : 151), 'idiomas'=>$this->opcionesIdiomas(isset($registro['idioma_id']) ? $registro['idioma_id'] : 9)]),
            '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas(isset($registro['cobertura_id']) ? $registro['cobertura_id'] : null), 'nombre'=>isset($registro['nombre']) ? $registro['nombre'] : null, 'descripcion'=>isset($registro['descripcion']) ? $registro['descripcion'] : null,'alias'=>isset($registro['alias']) ? $registro['alias'] : null]),
            'entidadesAPF'=>$this->opcionesEntidadesAPF(isset($registro['entidad_apf_id']) ? $registro['entidad_apf_id'] : null),
            'palabras'=>isset($registro['palabra_clave']) ? $this->opcionesPalabrasClave(!empty($registro['palabra_clave']) ? $registro['palabra_clave'] : '') : '',
            'tipos'=>$this->opcionesCategoriaProyecto(isset($registro['tipo_id']) ? $registro['tipo_id'] : null), 
            'paises'=>$this->opcionesPaises(isset($registro['pais_id']) ? $registro['pais_id'] : null),
            'redes'=>$this->opcionesRedesSociales(isset($registro['redes']) ? explode(' ', $registro['redes']) : null),
            'ficha'=>self::FICHA,
            'doc'=>$registro,
            'id'=>$id
        ];

        return view(
            'proyectos/documentos/parcial/_v_form_nota_prensa', 
            $datos            
        );

    }
}
