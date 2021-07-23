<?php 
namespace App\Libraries\Proyecto\Documento;
use App\Libraries\Proyecto\CProyecto;
use App\Models\NotaPrensaModel;

class NotaDePrensa extends Documento
{
    const SECCION = "nota-prensa";

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

        $carga = self::getInstanciaCarga($this->proyecto, self::SECCION);

        if (!$carga->existeDirectorio()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró el directorio: '.$carga->getDirectorio()];
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
            'seccion'=> self::SECCION,
            'bloque'=>self::SECCION,
            'registro_id'=> $id,            
        ]);
        return ['Solicitud'=>true, 'Msg'=>'Documento cargado correctamente.'];
    }

    public function vistaForm()
    {
        return view(
            'proyectos/documentos/parcial/_v_form_nota_prensa', 
            [
                '_v_conjunto_datos'=>$this->vistaConjuntoDatos(['instituciones'=>$this->opcionesInstituciones(), 'conjuntoDatos'=>$this->opcionesConjuntoDatos()]),
                '_v_pais_idioma'=>$this->vistaPaisIdioma(['paises'=>$this->opcionesPaises(), 'idiomas'=>$this->opcionesIdiomas()]),
                '_v_nombre_doc'=>$this->vistaNombreDoc(['coberturas'=>$this->opcionesCoberturas()]),
                'entidadesAPF'=>$this->opcionesEntidadesAPF(),
                'tipos'=>$this->opcionesCategoriaProyecto(), 
                'redes'=>$this->opcionesRedesSociales(),
                'paises'=>$this->opcionesPaises(),
            ]
        );

    }
}
