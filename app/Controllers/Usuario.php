<?php

namespace App\Controllers;
use  App\Libraries\Usuario as CUsuario;

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
        $actual = md5($this->usuario->getAttribute('password'));
        if (encriptarPassword($this->request->getPost('anterior')) != $actual) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La contraseña es incorrecta.']);return;
        }
    }
}
