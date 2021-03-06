<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo, CAccion, CSubAccion};
use App\Models\{AccionEspecificaModel, EvidenciaModel, AvanceModel};
use App\Traits\{CifradoTrait};
use  App\Libraries\Usuario;

class AccionParticular extends BaseController
{
    const SECCION = 'evidencias-acciones';
    protected $accionEspecificaModel;
    protected $evidenciaModel;
    protected $encrypter; 
    protected $usuario;
    protected $permisosModulo;

    use CifradoTrait;
    #use PermisoTrait;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();          
        $this->evidenciaModel = new EvidenciaModel();
        $this->encrypter = \Config\Services::encrypter(); 
        $this->accionEspecificaModel = new AccionEspecificaModel(); 
        $this->permisosModulo = $this->usuario->obtenerAccionesModulo('Proyecto');        
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
                    'vistaContenido'=>count($docs)>0 ? view('proyectos/parcial/_v_visor_doc', ['titulo'=>'Evidencia', 'url'=>isset($docs[0]['ruta']) ? $docs[0]['ruta'] : '']) : ''
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
        $accion = $this->accionEspecificaModel->find($this->desencriptar($idAccion)) ?? [];
        foreach ($this->obtenerAvances($this->desencriptar($idAccion)) as $avance) {
            
            $avance['id']        = base64_encode($this->encriptar($avance['id']));
            $avance['accion_id'] = base64_encode($this->encriptar($avance['accion_id']));
            $avance['validarEvidencia'] = $this->puedeValidar($accion, $avance);
            
            $html .= view('proyectos/seguimiento/parcial/_v_separador_avance', $avance);
            $html .= $this->iterarEvidencias($docs, $this->desencriptar( base64_decode($avance['id']) ), $accion, $avance);
        }

        return $html;
    }

    public function iterarEvidencias($docs, $bloque, $accion=[], $avance=[])
    {   $eliminar = $this->puedeEliminar($accion, $avance);
        $html = "<div class='row'>";
        foreach ($docs as $doc) {
            if ($doc['bloque']!=$bloque) {
                continue;
            }
            $doc['bloque'] = base64_encode($this->encriptar($doc['bloque']));
            $html .= view('proyectos/seguimiento/parcial/_v_item_doc', array_merge($doc, ['eliminarEvidencia'=>$eliminar]));
        }

        return $html."</div>";
    }

    public function actualizarAvance()
    {
        if ( !$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'No se recibi?? el Identificador de la Acci??n.'
            ]);
            return;
        }

        if ( !is_numeric($this->request->getPost('avance'))) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'El Avance debe ser una cantidad num??rica.'
            ]);
            return;
        }

        $campos = [
            'id'=>$this->desencriptar(base64_decode($this->request->getPost('id'))), 
            'avance'=>$this->request->getPost('avance')
        ];

        if (!$this->actualizar($campos)) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar actualizar el avance.'
            ]);
            return;
        }
        echo json_encode([
            'Solicitud'=>true, 
            'reporte'=>$this->reportarAvance($campos['id'], $campos['avance'], $this->request->getPost('anterior') ?? null),
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

    public function reportarAvance($accionId, $avance, $anterior=null)
    {
        $avanceModel = new AvanceModel();

        $campos = ['avance'=>$avance, 'accion_id'=>$accionId, 'creado_por'=>$this->usuario->getId()];

        if (is_numeric($anterior)) {
            $campos['anterior'] = $anterior;
        }
        return $avanceModel->insert($campos);
    }

    public function cargarArchivo()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud' =>false,
                'Error'=>'No se recibi?? el Identificador de la Acci??n.',
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

    public function validarAvance()
    {
        $avanceModel = new AvanceModel();
        if (!$avanceModel->update($this->desencriptar(base64_decode($this->request->getPost('id'))), ['validado'=>1, 'validado_el'=>'now()', 'validado_por'=>$this->usuario->getId()])) {
            echo json_encode(['Solicitud' =>false, 'Error'=>'Error al intentar validar el avance.']);return;             
        }
        #$this->accionEspecificaModel->update($this->desencriptar(base64_decode($this->request->getPost('id'))), ['avance']);
        echo json_encode(['Solicitud' =>true, 'Msg'=>'Avance validado correctamente.']); 
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

    protected function puedeValidar($accion, $avance)
    {
        if (!isset($this->permisosModulo[32])) {
            return false;
        }
        return !$this->estaValidado($accion, $avance); 
    }

    protected function puedeEliminar($accion, $avance)
    {
        if (!isset($this->permisosModulo[29])) {
            return false;
        }
        
        $accionGral = new CAccion($accion['accion_id']);
        $proyecto = new CProyecto($accionGral->getProyectoId());

        return !$this->estaValidado($accion, $avance) 
        || $this->tieneFacultad([$accionGral->getCoordinadorId(),$proyecto->getCoordinadorId()]);
    }
    
    protected function estaValidado($accion, $avance)
    {
        return ($accion['evidencia']==1 && $avance['validado']==1) || ($accion['evidencia']==0);
    }

    protected function tieneFacultad($usuarios)
    {
        return in_array($this->usuario->getId(), $usuarios);
    }
}
