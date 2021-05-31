<?php

namespace App\Controllers;

use App\Models\{PerfilModel, PermisoModel};
use  App\Libraries\Perfil\GestionPerfil;
use  App\Libraries\{Usuario};
use App\Models\CatalogoModel;
use App\Traits\InfoVistaTrait;

class PerfilUsuario extends BaseController
{   
    use InfoVistaTrait;

    protected $encrypter;
    protected $usuario;   

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario(); 
        $this->encrypter = \Config\Services::encrypter();              
    }

    public function index()
    {
        $perfil = new GestionPerfil(get_class($this));	
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'perfil/v_listado', 
                [
                    'listado'=>$perfil->obtenerListado(), 
                    'permisos'=>$this->usuario->obtenerPermisosModulo(get_class($this)),
                    'breadcrumbs'=>$this->generarBreadCrumbs(get_class($this)),
                    'modulo'=>$this->nombreModulo(get_class($this))
                ]
            )
        ]);
    }

    public function obtenerVistaFormPerfil()
    {
        $perfil = $this->request->getPost('id')
                ? $this->obtenerPerfil($this->encrypter->decrypt(base64_decode($this->request->getPost('id')))) : null;
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('perfil/v_form_perfil', 
                [
                    'perfiles'=>$this->listadoPerfiles($perfil['id']??null),
                    'v_acciones'=> view('perfil/parcial/_v_acciones'),
                    'perfil'=>$perfil
                ])
        ]);
    }

    public function cambiarEstatus()
    {
        $perfilModel = new PerfilModel();
        $estatus = $this->request->getPost('estatus')==1 ? 2 : 1;

        $update = $perfilModel->update( 
            $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), 
            ['estatus'=>$estatus] 
        ); 

        if ($update===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar '.($estatus==1?'activar':'desactivar').' el perfil.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Perfil '.($estatus==1?'activado':'desactivado').' correctamente.', 'estatus'=>$estatus]); 

    }

    public function obtenerModulos()
    {
        $perfilId = $this->request->getPost('id') 
        ? $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) : 0;

        $perfil = new GestionPerfil(get_class($this));

        echo json_encode([
            'Solicitud'=>true, 
            'arbol'=>$perfil->obtenerArbolPermiso($perfilId)
        ]); 
    }

    public function guardarPerfil()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }
        
        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        } 
        
        $datos = [
			'nombre'=>trim($this->request->getPost('nombre')),
			'descripcion'=>trim($this->request->getPost('descripcion'))	
		];

        if (!$this->request->getPost('id')) {
            $datos['creado_por'] = $this->usuario->getId();
        }
        #echo '<pre>';print_r($datos);exit;
        $id = $this->insertaAcualizaPerfil($datos, $this->request->getPost('id'));

        if (!$this->agregarPermisos($id, $this->request->getPost('permisos'))) {
            echo json_encode(['Solicitud'=>true, 'Msg'=>'No se asignaron permisos para el perfil.']);return;
        }
        echo json_encode([
            'Solicitud'=>true, 
            'Msg'=>'Perfil '.($this->request->getPost('id') ? 'actualizado correctamente.' : 'creado correctamente.')
        ]);
    }

    public function listadoPerfiles($perfilId=null)
    {
        $listado = "<option value=''></option>";

        foreach ($this->obtenerPerfiles() as $perfil) {
            $selected = $perfilId==$perfil['id'] ? 'disabled' : '';
            $listado .= sprintf("<option value='%d' %s>%s</option>", $perfil['id'], $selected, $perfil['nombre']);
        }
        return $listado;
    }

    protected function obtenerPerfiles()
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo('gp_perfiles', '*', 1);
    }

    protected function obtenerPerfil($id)
    {
        $perfilModel = new PerfilModel();
        return $perfilModel->find($id);
    }

    protected function insertaAcualizaPerfil($datos, $id=null)
    {
        $perfilModel = new PerfilModel();
        if (!$id) {#var_dump($perfilModel->insert($datos));exit;
            return $perfilModel->insert($datos); 
        }
 
        $perfilModel->update( $this->encrypter->decrypt(base64_decode($id)), $datos );

        return $this->encrypter->decrypt(base64_decode($id));
    }

    protected function agregarPermisos($perfilId, $permisos)
    {
        $permisoModel = new PermisoModel();
        $modulos = []; $agregados = false;

        foreach ($permisos as $key => $permiso) {
            $infoPermiso = $permisoModel->where(['perfil_id'=>$perfilId, 'modulo_id'=>$key])->first();
            $modulos[] = $key;

            if (isset($infoPermiso['id'])) {
                $permisoModel->update($infoPermiso['id'], ['estatus'=>1, 'acciones'=>implode(',', $permiso['acciones'])])
                ? $agregados = true : '';
                continue;
            }

            $permisoModel->insert(['perfil_id'=>$perfilId, 'modulo_id'=>$key, 'acciones'=>implode(',', $permiso['acciones'])])
            ? $agregados = true : '';
        }
        if (count($modulos)>0) {
            $this->desactivarPermisos($perfilId, $modulos);
        }
        return $agregados;
    }
    protected function desactivarPermisos($perfilId, $modulos)
    {
        $permisoModel = new PermisoModel();
        $permisos = $permisoModel->where(['perfil_id'=>$perfilId])->findAll() ?? [];
        foreach ($permisos as $permiso) {
            if (in_array($permiso['modulo_id'], $modulos)) {
                continue;
            }
            $permisoModel->update($permiso['id'], ['estatus'=>0]);
        }
    }

    protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            [
				'nombre'=>$this->request->getPost('nombre'),
				'descripcion'=>$this->request->getPost('descripcion'),
				'padre'=>$this->request->getPost('padre')
			],
            'profile_user'
        );
        
        if ($validation->hasError('nombre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('nombre')];
        }
        if ($validation->hasError('descripcion')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('descripcion')];
        }
		if ($validation->hasError('padre')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('puesto')];
        }

        $permisos = $this->request->getPost('permisos');

		if (!is_array($permisos) || count($permisos)==0) {
            return ['Solicitud'=>false, 'Error'=>'No se recibieron permisos para el perfil.'];
        }

        return ['Solicitud'=>true];
    }
}
