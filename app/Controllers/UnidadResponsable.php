<?php

namespace App\Controllers;

use  App\Libraries\Entidad\GestionUR;
use App\Models\{MunicipioModel};
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

    public function vistaForm()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'ur/v_modal_ur', 
                [
                    'entidades'=>$this->listadoEntidades()
                ]
            )
        ]);
    }

    public function obtenerListadoMunicipios()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'listado'=>$this->listadoMunpios($this->obtenerMunicipios($this->request->getPost('entidad')))
        ]);
    }

    public function guardar()
    {
        echo '<pre>';print_r($this->request->getPost());exit;
    }

    public function listadoMunpios($municipios, $municipioId=null)
    {
        $listado = "<option value=''></option>";

        foreach ($municipios as $municipio) {
            $selected = $municipioId==$municipio['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%d' %s>%s</option>", $municipio['id'], $selected, $municipio['municipio']);
        }
        return $listado;
    }

    public function listadoEntidades($entidadId=null)
    {
        $listado = "<option value=''></option>";

        foreach ($this->obtenerEntidades() as $entidad) {
            $selected = $entidadId==$entidad['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%d' %s>%s</option>", $entidad['id'], $selected, $entidad['estado']);
        }
        return $listado;
    }

    protected function obtenerEntidades()
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo('gp_estados', '*', 1);
    }

    protected function obtenerMunicipios($entidadId)
    {
        $municipioModel = new MunicipioModel();
        return $municipioModel->where('estado_id', $entidadId)->orderBy('municipio', 'ASC')->findAll()??[];        
    }
}
