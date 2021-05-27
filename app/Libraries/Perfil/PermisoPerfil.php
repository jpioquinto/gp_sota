<?php 
namespace App\Libraries\Perfil;
use App\Models\PermisoModel;

class PermisoPerfil
{
    protected $perfilId;
    protected $permisos;

    function __construct($perfilId=-1)
    {
        $this->perfilId = $perfilId;
        $this->permisos = $this->obtenerPermisos($perfilId);
    }

    public function obtenerPermisos($perfilId = 0)
    {
        $permisos = [];
        foreach ($this->listarPermisos() as $permiso) {
            $permisos[$permiso['modulo_id']]['permisos'] = explode(',', $permiso['acciones']);

        }
        return $permisos;
    }

    public function listarPermisos($perfilId)
    {
        $permisoModel = new PermisoModel();
        return $permisoModel->find($perfilId);
    }

    public function tienePermiso($accion)
    {
        return array_search($accion, array_column($this->permisos, 'id'));
    }
}
