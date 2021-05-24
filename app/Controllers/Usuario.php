<?php

namespace App\Controllers;
use  App\Libraries\Usuario as CUsuario;
use  App\Libraries\Usuario\GestionUsuario;
use App\Models\{UsuarioModel, ContactoModel};
use App\Models\CatalogoModel;

class Usuario extends BaseController
{   
    protected $usuario;     
    public function __construct()
    {
        @session_start();   
        $this->usuario = new CUsuario();              
    }

    public function index()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}
		$gestoUser = new GestionUsuario(get_class($this));
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('usuario/v_listado', ['listado'=>$gestoUser->obtenerListado()])
            ]);
    }

    public function obtenerVistaNuevo()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('usuario/parcial/_v_modal_nuevousuario', ['perfiles'=>$this->listadoPerfiles()])
        ]);
    }

    public function obtenerVistaCambio()
    {
        echo json_encode(['Solicitud'=>true, 'vista'=>view('usuario/v_cambiar_password')]);
    }

    public function cambiarPassword()
    {
        helper('usuario');
        if ($this->usuario->getId()<1) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar obtener el usuario.']);return;
        }
        if (trim($this->request->getPost('nueva'))!=trim($this->request->getPost('copianueva'))) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La nueva contraseña y su confirmación no coinciden.']);return;
        }        
        if (encriptarPassword($this->request->getPost('anterior')) != $this->usuario->getAttribute('password')) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La contraseña es incorrecta.']);return;
        }

        $userModel = new UsuarioModel();        
        if($userModel->update($this->usuario->getId(), ['password'=>encriptarPassword( trim($this->request->getPost('nueva')) )])===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al cambiar la contraseña.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'La contraseña ha sido cambiada correctamente.']); 
    }

    public function agregarUsuario()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }
        
        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        } 

        helper('usuario');
		$usuarioModel = new UsuarioModel();

		$datos = [
			'nickname'=>trim($this->request->getPost('usuario')),
			'password'=>encriptarPassword(trim($this->request->getPost('password'))),
			'perfil_id'=>$this->request->getPost('perfil'),            
			'creado_por'=>$this->usuario->getId()			
		];

        if (($id = $usuarioModel->insert($datos))===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar guardar el usuario.']);return;
        }

        $contactoModel = new ContactoModel();
        $contactoModel->save(['usuario_id'=>$id, 'organizacion_id'=>$this->usuario->getOrganizacionId()]);

        echo json_encode(['Solicitud'=>true, 'Msg'=>'Usuario creado correctamente.']);
    }

    public function verficarExistencia()
    {
        $userModel = new UsuarioModel();
        $usuario = $userModel->where('nickname', $this->request->getPost('usuario'))->first();
        echo json_encode(['Solicitud'=>true, 'existe'=>isset($usuario['nickname'])]);  
    }

    public function listadoPerfiles()
    {
        $listado = "<option value=''></option>";

        foreach ($this->obtenerPerfiles() as $perfil) {
            $listado .= sprintf("<option value='%d'>%s</option>", $perfil['id'], $perfil['nombre']);
        }
        return $listado;
    }

    protected function obtenerPerfiles()
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo('gp_perfiles', '*', 1);
    }

    protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            [
				'usuario'=>$this->request->getPost('usuario'),
				'password'=>$this->request->getPost('password'),
				'copiapassword'=>$this->request->getPost('copiapassword'),
				'perfil'=>$this->request->getPost('perfil')
			],
            'user'
        );
        
        if ($validation->hasError('usuario')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('usuario')];
        }
        if ($validation->hasError('password')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('password')];
        }
		if ($validation->hasError('copiapassword')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('copiapassword')];
        }
		if ($validation->hasError('perfil')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('perfil')];
        }
        return ['Solicitud'=>true];
    }
}
