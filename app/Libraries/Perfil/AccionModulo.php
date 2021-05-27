<?php 
namespace App\Libraries\Perfil;
use  App\Libraries\{Usuario};
use App\Models\AccionModel;

class AccionModulo
{	
    protected $acciones;
    protected $permisos;
    protected $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario(); 
        $this->acciones = [];
        $this->permisos = [];
        
    }

    public function obtenerPermisos()
    {
        $permisos = [];
        foreach ($this->usuario->permisos as $permiso) {

        }
    }

    public function obtenerAcciones($id)
    {
        $accionModel = new AccionModel();

        return $this->acciones = $accionModel->orderBy('descripcion', 'ASC')->find($id);

    }

    public function asignarIcono($acciones, $icon='icon-wrench')
    {
        foreach ($acciones as $index=>$value) {
            $acciones[$index]['icono'] = $icon;
            $acciones[$index]['nombre'] = $value['descripcion'];
        }
        return $acciones;
    }
   
}
