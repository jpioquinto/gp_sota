<?php

namespace App\Controllers;

use App\Models\{PerfilModel, PermisoModel};
use  App\Libraries\Entidad\GestionUR;
use  App\Libraries\{Usuario};
use App\Models\CatalogoModel;
use App\Traits\InfoVistaTrait;

class UnidadResponsable extends BaseController
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
        $urs = new GestionUR(get_class($this));	
        
       echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'ur/v_listado', 
                [
                    'listado'=>$urs->obtenerListado(), 
                    'permisos'=>$this->usuario->obtenerPermisosModulo(get_class($this)),
                    'breadcrumbs'=>$this->generarBreadCrumbs(get_class($this)),
                    'modulo'=>$this->nombreModulo(get_class($this))
                ]
            )
        ]);
    }
}
