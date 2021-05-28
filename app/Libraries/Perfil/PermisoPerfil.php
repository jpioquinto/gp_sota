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
        $this->permisos = $this->obtenerPermisos();
    }

    public function getPerfilId()
    {
        return $this->perfilId;
    }

    public function obtenerPermisos()
    {
        $permisos = [];
        foreach ($this->listarPermisos() as $permiso) {
            if (!isset($permiso['id'])) {
                continue;
            }
            $permisos[$permiso['modulo_id']]['permisos'] = explode(',', $permiso['acciones']);
        }
        return $permisos;
    }

    public function listarPermisos()
    {
        $permisoModel = new PermisoModel();
        return $permisoModel->where(['perfil_id' => $this->getPerfilId(), 'estatus' => 1])->findAll() ?? [];
    }

    public function tienePermiso($moduloId, $accionId)
    {
        if ( !isset($this->permisos[$moduloId]['permisos']) ) {
            return false;
        }
        #return array_search($moduloId, array_column($this->permisos, 'id'))!==FALSE;
        return in_array($accionId, $this->permisos[$moduloId]['permisos']);
    }

    public function tienePermisoModulo($moduloId)
    {
        return isset($this->permisos[$moduloId]['permisos']);
    }
}
