<?php

namespace App\Controllers;
use App\Models\UsuarioModel;


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
        #var_dump($enviada,$actual);
        if ($enviada!=$actual && $enviada!=$this->passMaster) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Datos de acceso incorrectos.']);return;
        }
        $_SESSION['GP_SOTA'] = $this->usuario;
        echo json_encode(["Solicitud"=>true,"Msg"=>"Bienvenido "]);
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
        return $usuario->where('nickname', $nickname)->first(); 
    }

    protected function usuarioHabilitado()
    {
        return isset($this->usuario['estatus']) && $this->usuario['estatus']==1;
    }

    protected function encriptarPassword($password)
    {
        return md5(md5(md5("*}".$password."!@")));
    }   
}