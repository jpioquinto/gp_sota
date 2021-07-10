<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo, CAccion, CSubAccion};
use App\Models\{AccionEspecificaModel, EvidenciaModel, AvanceModel};
use App\Traits\CifradoTrait;
use  App\Libraries\Usuario;

class AccionParticular extends BaseController
{
    const SECCION = 'evidencias-acciones';
    protected $accionEspecificaModel;
    protected $evidenciaModel;
    protected $encrypter; 
    protected $usuario;

    use CifradoTrait;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();          
        $this->evidenciaModel = new EvidenciaModel();
        $this->encrypter = \Config\Services::encrypter(); 
        $this->accionEspecificaModel = new AccionEspecificaModel();         
    }

    public function vistaCargarDocs()
    {        
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/parcial/_v_modal_carga_docs', $this->request->getPost())
        ]);
    }

    public function vistaEditarAvance()
    {
        $params = $this->request->getPost();
        if ($params['evidencia']==1) {
            $params['v_elige_archivo'] = view('proyectos/parcial/_v_elige_archivos', $params);
        }
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/parcial/_v_modal_reporta_avance', $params)
        ]);
    }

    public function verDocumentos()
    {
        helper(['icons','util']);
        $docs = $this->listadoEvidencias(base64_decode($this->request->getPost('id')), base64_decode($this->request->getPost('proyectoId')));
        
        $datos = [
            'vistaContenedor'=>view(
                'proyectos/parcial/_v_dos_columnas', 
                [
                    'docs'=>$docs, 
                    'vistaListado'=>$this->agruparEvidencias(base64_decode($this->request->getPost('id')), $docs),
                    'vistaContenido'=>view('proyectos/parcial/_v_visor_doc', ['titulo'=>'Evidencia', 'url'=>isset($docs[0]['ruta']) ? $docs[0]['ruta'] : ''])
                ]
            ),
            'docs'=>$docs
        ];
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/parcial/_v_modal_ver_docs', $datos)
        ]);
    }

    public function agruparEvidencias($idAccion, $docs)
    {   
        $html = '';     
        foreach ($this->obtenerAvances($this->desencriptar($idAccion)) as $avance) {

            $html .= view('proyectos/seguimiento/parcial/_v_separador_avance', $avance);
            $html .= $this->iterarEvidencias($docs, $avance['id']);
        }

        return $html;
    }

    public function iterarEvidencias($docs, $bloque)
    {
        $html = "<div class='row'>";
        foreach ($docs as $doc) {
            if ($doc['bloque']!=$bloque) {
                continue;
            }
            $html .= view('proyectos/seguimiento/parcial/_v_item_doc', $doc);
        }

        return $html."</div>";
    }

    public function actualizarAvance()
    {
        if ( !$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'No se recibió el Identificador de la Acción.'
            ]);
            return;
        }

        if ( !is_numeric($this->request->getPost('avance'))) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'El Avance debe ser una cantidad numérica.'
            ]);
            return;
        }

        if (!$this->actualizar($campos=['id'=>$this->desencriptar(base64_decode($this->request->getPost('id'))), 'avance'=>$this->request->getPost('avance')])) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar actualizar el avance.'
            ]);
            return;
        }
        echo json_encode([
            'Solicitud'=>true, 
            'reporte'=>$this->reportarAvance($campos['id'], $campos['avance']),
            'Msg'=>'Avance actualizado correctamente.'
        ]);
    }

    public function actualizar($campos, $id=null)
    {
        if (isset($campos['id'])) {
            return $this->accionEspecificaModel->save($campos);
        }

        if ($id && is_numeric($id)) {
            return $this->accionEspecificaModel->update($id, $campos);
        }

        return false;
    }

    public function reportarAvance($accionId, $avance)
    {
        $avanceModel = new AvanceModel();

        return $avanceModel->insert(['avance'=>$avance, 'accion_id'=>$accionId, 'creado_por'=>$this->usuario->getId()]);
    }

    public function cargarArchivo()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibió el Identificador de la Acción.',
            ]);	
            return; 
        }
        
        $cargaArchivo = new CCargaArchivo(new CProyecto( $this->encrypter->decrypt( base64_decode($this->request->getPost('proyectoId'))) ));
        $carga = $cargaArchivo->mover(
            $this->request->getFile('archivo'), 
            $this->generarNombre( $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))) )
        );
        
        if (!$carga['Solicitud']) {
            echo json_encode($carga);return;
        }
                
        $this->guardarEvidencia([            
            'proyecto_id'=> $this->encrypter->decrypt( base64_decode($this->request->getPost('proyectoId'))),
            'registro_id'=> $this->encrypter->decrypt( base64_decode($this->request->getPost('id'))),            
            'bloque'=>$this->request->getPost('bloque') ? $this->request->getPost('bloque') : '',
            'descripcion'=>$this->request->getPost('descripcion'),
            'creado_por'=>$this->usuario->getId(),
            'seccion'=> self::SECCION,
            'ruta'=>$carga['url'],
        ]);

        echo json_encode($carga);
    }

    public function guardarEvidencia($campos)
    {
        return $this->evidenciaModel->insert($campos);
    }

    public function generarNombre($id)
    {
        $especifica = new CSubAccion($id);
        $general = new CAccion( $especifica->obtenerIdAccionGeneral() );

        $accion = $general->obtenerAccion();

        return "accion-{$accion['orden']}-especifica-".$this->posicionAccionEspecifica($general->obtenerSubAcciones(), $id);
    }

    protected function posicionAccionEspecifica($subAcciones, $id)
    {
        $indice = array_search($id, array_column($subAcciones, 'id'));

        return $indice===FALSE ? 0 : $indice + 1;
    }

    protected function listadoEvidencias($id, $proyectoId)
    {
       # return $this->obtenerEvidencias($this->desencriptar($id), $this->desencriptar($proyectoId));
        return $this->comprobarExistenciaFisica(
            $this->obtenerEvidencias($this->desencriptar($id), $this->desencriptar($proyectoId))
        );
    }

    protected function obtenerEvidencias($id, $proyectoId)
    {
        return $this->evidenciaModel
        ->where(['registro_id'=>$id, 'proyecto_id'=>$proyectoId, 'seccion'=>self::SECCION, 'estatus'=>1])
        ->orderBy('bloque ASC, ruta ASC')
        ->findAll() ?? [];
    }

    protected function comprobarExistenciaFisica($docs)
    {
        $documentos = [];
        foreach ($docs as $doc) {            
            if (!file_exists($doc['ruta'])) {
                continue;
            }            
            $documentos[]  = $doc;
        }
        return $documentos;
    }

    protected function obtenerAvances($idAccion)
    {
        $avanceModel = new AvanceModel();
        return $avanceModel->where(['accion_id'=>$idAccion, 'estatus'=>1])->findAll() ?? [];
    }
}
