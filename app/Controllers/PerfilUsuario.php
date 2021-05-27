<?php

namespace App\Controllers;
use  App\Libraries\Perfil\GestionPerfil;
use  App\Libraries\{Usuario};
use App\Models\CatalogoModel;
use App\Models\PerfilModel;

class PerfilUsuario extends BaseController
{   
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
            'vista'=>view('perfil/v_listado', ['listado'=>$perfil->obtenerListado()])
        ]);
    }

    public function obtenerVistaFormPerfil()
    {
        $perfil = $this->obtenerPerfil($this->encrypter->decrypt(base64_decode($this->request->getPost('id'))));
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('perfil/v_form_perfil', 
                [
                    'perfiles'=>$this->listadoPerfiles($perfil['id']??null),
                    'v_acciones'=> view('perfil/parcial/_v_acciones'),
                    'perfil'=>$perfil??null
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
        $perfil = new GestionPerfil(get_class($this));
        echo json_encode([
            'Solicitud'=>true, 
            'arbol'=>$perfil->generarArbol()
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
}
