<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\InvestigacionModel;

class Investigacion extends Documento
{
    const FICHA = "investigacion";

    public function __construct(CProyecto $proyecto)
    {  
        parent::__construct($proyecto);        
    }

    public function guardar($datos, $archivo)
    {
        $validacion = $this->validacion->esSolicitudInvestigacionValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $carga = self::getInstanciaCarga($this->proyecto, self::FICHA);

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
        }

        $campos = [
            'formato'=>strtolower( obtenExtension($archivo->getName()) ),
            'proyecto_id'=>$this->proyecto->getId(),
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),            
            'cobertura_id'=>$datos['cobertura'],
            'pais_id'=>$datos['pais'], 
            'idioma_id'=>$datos['idioma'], 
            'tema'=>$datos['tema'],
            'autor1'=>$datos['autor'],
            'clasificacion_id'=>$datos['clasificacion'], 
            'conjunto_dato_id'=>$datos['conjunto_datos'],       
            'institucion_id'=>$datos['institucion'],            
            'anio_publicado'=>$datos['publicado'],
            'num_paginas'=>$datos['paginas'],                            
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

        if (isset($datos['autor3']) && trim($datos['autor3'])!='') {
            $campos['autor3'] = trim($datos['autor3']);
        }

        if (isset($datos['detalle']) && trim($datos['detalle'])!='') {
            $campos['detalle_publicacion'] = trim($datos['detalle']);
        }

        if (isset($datos['editorial']) && trim($datos['editorial'])!='') {
            $campos['editorial'] = trim($datos['editorial']);
        }

        if (isset($datos['edicion']) && trim($datos['edicion'])!='') {
            $campos['edicion'] = trim($datos['edicion']);
        }

        if (isset($datos['isbn']) && trim($datos['isbn'])!='') {
            $campos['isbn'] = trim($datos['isbn']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }        
        
        $mover = $carga->mover($archivo, quitaExtension($campos['nombre'])); 
        
        if (!$mover['Solicitud']) {
            return ['Solicitud'=>false, 'Error'=>'Error al intentar cargar el documento '.$datos['nombre'] ];
        }

        $investigacionModel = new InvestigacionModel();
        
        if (!($id = $investigacionModel->insert($campos))) {
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
        $validacion = $this->validacion->esSolicitudInvestigacionValida($datos);

        if ($validacion['Solicitud']===FALSE) {
            return $validacion;
        }#var_dump($archivo);exit;

        $campos = [
            'descripcion'=>trim($datos['descripcion']),
            'alias'=>trim($datos['alias']),            
            'cobertura_id'=>$datos['cobertura'],
            'pais_id'=>$datos['pais'], 
            'idioma_id'=>$datos['idioma'], 
            'tema'=>$datos['tema'],
            'autor1'=>$datos['autor'],
            'clasificacion_id'=>$datos['clasificacion'], 
            'conjunto_dato_id'=>$datos['conjunto_datos'],       
            'institucion_id'=>$datos['institucion'],            
            'anio_publicado'=>$datos['publicado'],
            'num_paginas'=>$datos['paginas'],                            
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

        if (isset($datos['autor3']) && trim($datos['autor3'])!='') {
            $campos['autor3'] = trim($datos['autor3']);
        }

        if (isset($datos['detalle']) && trim($datos['detalle'])!='') {
            $campos['detalle_publicacion'] = trim($datos['detalle']);
        }

        if (isset($datos['editorial']) && trim($datos['editorial'])!='') {
            $campos['editorial'] = trim($datos['editorial']);
        }

        if (isset($datos['edicion']) && trim($datos['edicion'])!='') {
            $campos['edicion'] = trim($datos['edicion']);
        }

        if (isset($datos['isbn']) && trim($datos['isbn'])!='') {
            $campos['isbn'] = trim($datos['isbn']);
        }

        if (isset($datos['url']) && trim($datos['url'])!='') {
            $campos['url'] = trim($datos['url']);
        }        

        $investigacionModel = new InvestigacionModel();
        
        if (!($investigacionModel->update($this->desencriptar(base64_decode($datos['id'])), $campos))) {
            return ['Solicitud'=>false, 'Msg'=>'Error al intentar actualizar la Ficha del Documento.'];
        }
        
        $registro = $investigacionModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($datos['id']))]);

        return [
            'Solicitud'=>true, 
            'Msg'=>'Ficha actualizada correctamente.',
            'detalle'=> view("proyectos/documentos/parcial/_v_seccion_".self::FICHA.".php", isset($registro[0]['id']) ? $registro[0] : [])
        ];                        
    }

    public function eliminar($id)
    {
        $docModel = new InvestigacionModel();
        
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
            $docModel = new InvestigacionModel();
            $registro =  $docModel->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId(), 'id'=>$this->desencriptar(base64_decode($id))]);
            $registro =  isset($registro[0]['id']) ? $registro[0] : [];         
        }

        $datos = [
            '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(isset($registro['institucion_id']) ? $registro['institucion_id'] : null), 'conjuntoDatos'=>$this->opcionesConjuntoDatos(isset($registro['conjunto_dato_id']) ? $registro['conjunto_dato_id'] : null)]),
            '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(isset($registro['pais_id']) ? $registro['pais_id'] : 151), 'idiomas'=>$this->opcionesIdiomas(isset($registro['idioma_id']) ? $registro['idioma_id'] : 9)]),
            '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas(isset($registro['cobertura_id']) ? $registro['cobertura_id'] : null), 'nombre'=>isset($registro['nombre']) ? $registro['nombre'] : null, 'descripcion'=>isset($registro['descripcion']) ? $registro['descripcion'] : null,'alias'=>isset($registro['alias']) ? $registro['alias'] : null]),
            'clasificaciones'=>$this->opcionesClasificaciones(isset($registro['clasificacion_id']) ? $registro['clasificacion_id'] : null),
            'palabras'=>isset($registro['palabra_clave']) ? $this->opcionesPalabrasClave(!empty($registro['palabra_clave']) ? $registro['palabra_clave'] : '') : '',
            'ficha'=>self::FICHA, 
            'doc'=>$registro,
            'id'=>$id 
        ];

        return view(
            'proyectos/documentos/parcial/_v_form_investigacion',
            $datos
        );

    }
}
