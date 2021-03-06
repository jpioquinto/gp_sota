<?php

namespace App\Controllers;
use App\Models\{UsuarioModel, UsuarioQuery, ContactoModel, AccionModel, ModuloModel};
use App\Libraries\Proyecto\CDependencia;


class Login extends BaseController
{
    protected $usuario;
    protected $passMaster;

    public function __construct()
    {
        @session_start();
        $this->usuario = []; 
        $this->passMaster = $this->encriptarPassword('S3d@7u.4T.MX');      
    }

    public function index()
    {
        if (isset($_SESSION['GP_SOTA']) && !empty($_SESSION['GP_SOTA'])) {	 
            return redirect()->to('/inicio');			
		}
		
        return view('login/v_login');
    }

    public function logout()
    {
        unset($_SESSION['GP_SOTA']);
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Sesión terminada.']);

    }

	public function loguear()
	{        		
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }
        
        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        } 

        if (is_null($this->usuario = $this->obtenerUsuario($this->request->getPost('usuario')))) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Éste usuario no está registrado.']);return;
        }
        
        if (!$this->usuarioHabilitado()) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'El usuario no está habilitado.']);return;
        }

        $actual = md5($this->usuario['password']);
        $enviada = $this->encriptarPassword($this->request->getPost('password'));
        
        if ($enviada!=$actual && $enviada!=$this->passMaster) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Datos de acceso incorrectos.']);return;
        }

        $ur = $this->comprobarUR($this->obtenerOrganizacion($this->usuario['id']));

        if ($ur['Solicitud']===FALSE) {
            echo json_encode($ur); return;
        }
        
        $this->usuario['organizacion_id'] = $ur['id'];
        
        $_SESSION['GP_SOTA'] = $this->usuario;
        $_SESSION['GP_SOTA']['permisos'] = $this->obtenerPermisos($this->usuario['perfil_id']);

        $this->actualizarUltimoAcceso($this->usuario['id']);

        echo json_encode([
            "Solicitud"=>true,
            "Msg"=>"Bienvenido ".(trim($this->usuario['nombre_completo'])!='' ? $this->usuario['nombre_completo'] : $this->usuario['nickname'])
        ]);
	}

    public function ordernarPermisos($permisoA, $permisoB)
    {
       if ($permisoA['nodo_padre'] != $permisoB['nodo_padre']) {
            return $permisoA['nodo_padre']>$permisoB['nodo_padre'];
        }
        return $permisoA['orden']>$permisoB['orden'];
    }   

    protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            ['usuario'=>$this->request->getPost('usuario'),'password'=>$this->request->getPost('password') ],
            'signin'
        );
        
        if ($validation->hasError('usuario')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('usuario')];
        }
        if ($validation->hasError('password')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('password')];
        }
        return ['Solicitud'=>true];
    }
    
    protected function obtenerUsuario($nickname)
    {
        $usuario = new UsuarioModel();

        $datos = $usuario->obtenerUsuario($nickname);
        return isset($datos[0]['id']) ? $datos[0] : null;#$usuario->where('nickname', $nickname)->first(); 
    }

    protected function actualizarUltimoAcceso($id)
    {
        $userModel = new UsuarioModel();
        return $userModel->where('id', $id)->set(['ultimo_acceso' => 'now()'])->update();
    }
    protected function usuarioHabilitado()
    {
        return isset($this->usuario['estatus']) && $this->usuario['estatus']==1;
    }

    protected function encriptarPassword($password)
    {
        return md5(md5(md5("*}".$password."!@")));
    }
    
    protected function obtenerOrganizacion($idUsuario)
    {
        $contactoModel = new ContactoModel();
        $info = $contactoModel->where('usuario_id', $idUsuario)->first();
        return isset($info['organizacion_id']) ? $info['organizacion_id'] : 0;
    }

    protected function obtenerPermisos($perfilId)
    {
        $usuarioQuery = new UsuarioQuery();
        return $this->procesarPermisos( $this->obtenerModulosPadre($usuarioQuery->obtenerPermisosModulos($perfilId)) );
    }

    protected function procesarPermisos($permisos)
    {
        $catalogoModel = new AccionModel();        
        foreach ($permisos as $index=>$value) {
            if (is_null($value['acciones']) || empty($value['acciones'])) {
                $permisos[$index]['acciones'] = [];
                continue;
            }

            $acciones = $catalogoModel->find(explode(',', $value['acciones']));

            $permisos[$index]['acciones'] = is_array($acciones) ? $acciones : [];
        }
        return $permisos;
    }

    protected function obtenerModulosPadre($modulos)
    {
        $moduloModel = new ModuloModel();		
        $listado = [];        
        foreach ($modulos as $value) {
            if ($value['nodo_padre']>0 && $this->existeRegistro($modulos, $value['nodo_padre'])===FALSE && $this->existeRegistro($listado, $value['nodo_padre'])===FALSE) {
                $modPadre = $moduloModel->find($value['nodo_padre']);
                isset($modPadre['id']) ? $listado[] = $modPadre : '';                
            }
            $listado[] = $value;
        }
        usort($listado, [get_class($this), 'ordernarPermisos']);        
        return $listado;
    }

    protected function existeRegistro($datos, $id, $columna='id')
	{
		return array_search($id, array_column($datos, $columna));
	}

    protected function comprobarUR($urId)
    {
        $ur = new CDependencia($urId);

        if (!$ur->existe()) {
            return ['Solicitud'=>false, 'Error'=>'No se encontró la Unidad Responsable del este usuario.'];
        }

        if (!$ur->estaActiva()) {
            return ['Solicitud'=>false, 'Error'=>'La Unidad Responsable de este usuario ha sido dada de baja.'];
        }

        return ['Solicitud'=>true, 'id'=>$ur->getId()];
    }
}
