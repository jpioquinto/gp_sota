<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo, CAccion, CSubAccion};
use App\Models\{AccionEspecificaModel, EvidenciaModel};
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

    public function verDocumentos()
    {
        helper('icons');
        $docs = $this->listadoEvidencias(base64_decode($this->request->getPost('id')), base64_decode($this->request->getPost('proyectoId')));
        
        $datos = [
            'vistaContenedor'=>view(
                'proyectos/parcial/_v_dos_columnas', 
                [
                    'docs'=>$docs, 
                    'vistaListado'=>"<div class='row'>".view('proyectos/parcial/_v_listado_docs',['docs'=>$docs])."</div>",
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

        if (!$this->actualizar(['id'=>$this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), 'avance'=>$this->request->getPost('avance')])) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar actualizar el avance.'
            ]);
            return;
        }
        echo json_encode([
            'Solicitud'=>true, 
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
            'seccion'=> self::SECCION,
            'ruta'=>$carga['url'],
            'descripcion'=>$this->request->getPost('descripcion'),
            'creado_por'=>$this->usuario->getId(),
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
        ->orderBy('ruta', 'ASC')
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
}
