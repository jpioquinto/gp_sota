<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{UIProyecto, UIAccion, CProyecto, CAccion, CSubAccion};
use App\Traits\{AccionGenetalTrait, AccionEspecificaTrait};
use App\Models\{AccionGeneralModel, AccionEspecificaModel};
use App\Libraries\Validacion\ValidaAccion;
use  App\Libraries\Usuario;

class Seguimiento extends BaseController
{
    protected $encrypter; 
    protected $usuario;

    use AccionGenetalTrait;
    use AccionEspecificaTrait;
    #use PermisoTrait;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();          
        $this->encrypter = \Config\Services::encrypter();                   
    }
    
    public function index()
    {
        $uiAccion = new UIAccion($this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ));

        $proyecto = new CProyecto($this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ));

        $infoProyecto = $proyecto->obtenerProyecto();#echo '<pre>';print_r($uiAccion->tablaAcciones());exit;

        $btnAcciones = view(
            'proyectos/parcial/_v_btn_accion_submodulo', ['permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto'), 'acciones'=>$this->usuario->obtenerAccionesModulo('Proyecto')]
        );#echo '<pre>';print_r($btnAcciones.$uiAccion->headerTitle());exit;

        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
                'proyectos/seguimiento/v_contenedor_modulo', 
                [
                    'acciones'=>'',
                    'listado'=>$uiAccion->tablaAcciones(), 
                    'permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')
                ]),
            'header'=>view(
                'proyectos/parcial/_v_header_titulo', 
                [
                    'alias'=>'Seguimiento'.(isset($infoProyecto['alias']) ? ' - '.$infoProyecto['alias'] : ''), 
                    'v_acciones'=>($btnAcciones.$uiAccion->headerTitle())
                ])
        ]);
    }

    public function gestionAcciones()
    {
        $uiAccion = new UIAccion($this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ));

        $proyecto = new CProyecto($this->encrypter->decrypt( base64_decode($this->request->getPost('id')) ));

        $infoProyecto = $proyecto->obtenerProyecto();

        echo json_encode([
            'Solicitud'=>true,
            'vista'=>view(
                'proyectos/seguimiento/v_contenedor', 
                [
                    'acciones'=>$uiAccion->listadoAcciones(), 
                    'permisos'=>$this->usuario->obtenerPermisosModulo('Proyecto')
                ]),
            'header'=>view(
                'proyectos/parcial/_v_header_titulo', 
                [
                    'alias'=>'Gesti??n de Acciones para el Proyecto'.(isset($infoProyecto['alias']) ? ' de '.$infoProyecto['alias'] : ''), 
                    'v_acciones'=>$uiAccion->headerTitle()
                ])
        ]);
    }

    public function obtenerVistaNueva()
    {
        $uiProyecto = new UIProyecto();
        
        $accion = [];
        if ($this->request->getPost('id')) {
            $accionModel = new AccionGeneralModel();
            $accion = $accionModel->find($this->encrypter->decrypt( base64_decode($this->request->getPost('id')))) ?? [];
            $accion['id']  = $this->request->getPost('id');
        }
        

        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'proyectos/seguimiento/v_modal_accion', 
                array_merge($accion, ['usuarios'=>$uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId(), isset($accion['coordinador_id']) ? $accion['coordinador_id'] : null)])
            )
        ]);
    }

    public function obtenerVistaFormSubAccion()
    {
        $uiProyecto = new UIProyecto();

        $accion = [];
        if ($this->request->getPost('id')) {
            $accionModel = new AccionEspecificaModel();
            $accion = $accionModel->find($this->encrypter->decrypt( base64_decode($this->request->getPost('id')))) ?? [];
            $accion['id']  = $this->request->getPost('id');
        }
         
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/seguimiento/v_modal_subaccion',
                array_merge(
                    $accion,
                    [
                        'usuarios'=>$uiProyecto->listadoUsuarios($this->usuario->getOrganizacionId(), isset($accion['responsable_id']) ? $accion['responsable_id'] : null),
                        'accion_id'=>$this->request->getPost('accion_id')
                    ]
                )
            )
        ]);
    }

    public function eliminarAccionGeneral()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'No se recibi?? el Identificador de la Acci??n.'
            ]);
            return;
        }

        $accion = new CAccion( $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );

        echo json_encode($accion->eliminarAccion());        
    }

    public function eliminarAccionEspecifica()
    {
        if (!$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'No se recibi?? el Identificador de la Acci??n Espec??fica.'
            ]);
            return;
        }

        $accion = new CSubAccion( $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );

        $respuesta = $accion->eliminarAccion();

        if ($respuesta['reasignado']) {
            $respuesta['vista'] = $this->vistaListadoSubAccion($accion->obtenerIdAccionGeneral());
        }

        echo json_encode($respuesta);  
    }

    public function guardarAccionEspecifica()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }

        $validacion = new ValidaAccion();
        
        $validar = $validacion->esSolicitudSubAccionValida($this->request->getPost());
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        }

        $datos = [
            'accion_id'=>$this->encrypter->decrypt(base64_decode(  $this->request->getPost('accion_id') )),
			'definicion'=>trim($this->request->getPost('definicion')),			
			'descripcion'=>trim($this->request->getPost('descripcion')),
			'responsable_id'=>$this->request->getPost('responsable'), 
			'programa'=>$this->request->getPost('programa'),
			'fecha_ini'=>$this->request->getPost('fecha_ini'),
            'fecha_fin'=>$this->request->getPost('fecha_fin'),
            'evidencia'=>$this->request->getPost('evidencia'),
            'meta'=>$this->request->getPost('meta')
		];

        if (is_numeric($this->request->getPost('avance')) !='' ) {
            $datos['avance'] = $this->request->getPost('avance');
        }

        if (trim($this->request->getPost('nota')) !='' ) {
            $datos['nota'] = trim($this->request->getPost('nota'));
        }

        if (!$this->request->getPost('id')) {            
            $datos['creado_por'] = $this->usuario->getId();
        }

        $id = $this->insertarActualizarSubAccion($datos, $this->request->getPost('id'));
        if ( !is_numeric($id) || $id<1 ) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar '.($this->request->getPost('id') ? 'actualizar' : 'crear').' la Acci??n Espec??fica.'
            ]);
            return;
        }
        
        echo json_encode([
            'Solicitud'=>true,
            'ponderacion'=>($podenracion = $this->asignarPonderacion($id)), 
            'vista'=>($podenracion>0 ? $this->vistaListadoSubAccion($datos['accion_id']) : $this->vistaItemSubAccion($id)),
            'Msg'=>'Acci??n Espec??fica '.($this->request->getPost('id') ? 'actualizada correctamente.' : 'creada correctamente.')
        ]);
    }

    public function guardarAccionGral()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }

        $validacion = new ValidaAccion();
        
        $validar = $validacion->esSolicitudAccionValida($this->request->getPost());
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        }

        $datos = [
            'proyecto_id'=>$this->encrypter->decrypt(base64_decode(  $this->request->getPost('proyecto_id') )),
			'definicion'=>trim($this->request->getPost('definicion')),			
			'descripcion'=>trim($this->request->getPost('descripcion')),
			'coordinador_id'=>$this->request->getPost('coordinador'), 
			'ponderacion'=>$this->request->getPost('ponderacion'),
			'orden'=>$this->request->getPost('orden')
		];

        if (trim($this->request->getPost('nota')) !='' ) {
            $datos['nota'] = trim($this->request->getPost('nota'));
        }

        if (!$this->request->getPost('id')) {            
            $datos['creado_por'] = $this->usuario->getId();
        }

        $oldAccion = null;

        if ($this->request->getPost('id')) {            
            $accion = new CAccion( $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );
            $oldAccion = $accion->obtenerAccion();
        }

        $id = $this->insertarActualizar($datos, $this->request->getPost('id'));
        if ( !is_numeric($id) || $id<1 ) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar '.($this->request->getPost('id') ? 'actualizar' : 'crear').'  la Acci??n General.'
            ]);
            return;
        }
    
        $accion = new CAccion($id);
        $newAccion = $accion->obtenerAccion();

        $uiAccion = new UIAccion($newAccion['id']);
        
        echo json_encode([
            'Solicitud'=>true, 
            'ponderacion'=>$accion->obtenerPonderacion(),
            'ordenado'=>$this->cambioOrden($oldAccion, $newAccion),
            'vista'=>($oldAccion && $this->cambioPonderacion($oldAccion, $newAccion)) ? $this->vistaListadoSubAccion($newAccion['id']) : $uiAccion->generaHTMLAccion($newAccion, $newAccion['orden']),
            'Msg'=>'Acci??n General '.($this->request->getPost('id') ? 'actualizada correctamente.' : 'creada correctamente.')
        ]);
    }

    public function insertarActualizar($datos, $id=null)
    {
        $accionModel = new AccionGeneralModel();
        if (!$id) {
            return $accionModel->insert($datos); 
        }
 
        $accionModel->update( $this->encrypter->decrypt(base64_decode($id)), $datos );

        return $this->encrypter->decrypt(base64_decode($id));
    }

    public function insertarActualizarSubAccion($datos, $id=null)
    {
        $accionModel = new AccionEspecificaModel();
        if (!$id) {
            return $accionModel->insert($datos); 
        }
 
        $accionModel->update( $this->encrypter->decrypt(base64_decode($id)), $datos );

        return $this->encrypter->decrypt(base64_decode($id));
    }

}
