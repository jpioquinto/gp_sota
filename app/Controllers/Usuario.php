<?php

namespace App\Controllers;
use  App\Libraries\Usuario as CUsuario;
use App\Models\UsuarioModel;

class Usuario extends BaseController
{   
    protected $usuario;     
    public function __construct()
    {
        @session_start();   
        $this->usuario = new CUsuario();              
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
}
