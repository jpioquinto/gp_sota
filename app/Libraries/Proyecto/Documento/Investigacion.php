<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\InvestigacionModel;

class Investigacion extends Documento
{
    const SECCION = "investigacion";

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

        $carga = self::getInstanciaCarga($this->proyecto, self::SECCION);

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
            'seccion'=> self::SECCION,
            'bloque'=>self::SECCION,
            'registro_id'=> $id,            
        ]);
        return ['Solicitud'=>true, 'Msg'=>'Documento cargado correctamente.'];                        
    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_investigacion',
            [
                '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(), 'conjuntoDatos'=>$this->opcionesConjuntoDatos()]),
                '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(), 'idiomas'=>$this->opcionesIdiomas()]),
                '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas()]),
                'clasificaciones'=>$this->opcionesClasificaciones(),  
            ]
        );

    }
}
