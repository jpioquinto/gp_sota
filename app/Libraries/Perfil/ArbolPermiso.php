<?php 
namespace App\Libraries\Perfil;
use  App\Libraries\Perfil\AccionModulo;
use App\Models\ModuloModel;

class ArbolPermiso
{	
    protected $permisoPerfil;
    protected $accionModulo;
    protected $pilaModulos;
    protected $modulos;   

    public function __construct($perfilId=0)
    {
        $this->permisoPerfil = new PermisoPerfil($perfilId);
        $this->accionModulo = new AccionModulo();        
        $this->pilaModulos = []; 
        $this->modulos = [];
    }

    public function generarArbol()
    {   
        $arbol = []; 
        foreach ($this->listadoModulos() as $modulo) {
            if (in_array($modulo['id'], $this->pilaModulos)) {
                continue;
            }
            $arbol = array_merge($arbol, $this->obtenerModulo($modulo));            
        }

        return $arbol;
    }

    public function listadoModulos()
    {
        $moduloModelo = new ModuloModel();
        return $this->modulos = $moduloModelo->where('estatus', 1)->orderBy('nodo_padre ASC, orden ASC')->findAll();
    }

    protected function obtenerModulo($modulo)
    {
        $this->agregarApila($modulo['id']);

        $acciones = $this->agregarAcciones($modulo);

        $itemModulo = $this->generarElemento(
            $modulo, $modulo['nodo_padre'], 
            ($this->esModuloPadre($modulo['id'])===FALSE && count($acciones)==0 && $this->permisoPerfil->tienePermisoModulo($modulo['id']))
        );

        if (count($acciones)>0) {
            $itemModulo = array_merge($itemModulo, ['children' => $acciones]);
        }

        if ($this->esModuloPadre($modulo['id'])===FALSE) {
            return [$itemModulo];
        }

        return [array_merge( $itemModulo, ['children' => $this->obtenerModulosHijos($modulo['id'])] )];        
    }

    protected function obtenerModulosHijos($idPadre)
    {
        $modulosHijos = [];
        foreach ($this->modulos as $modulo) {
            if ($modulo['nodo_padre']!=$idPadre || in_array($modulo['id'], $this->pilaModulos)) {
				continue;
			}

            $this->agregarApila($modulo['id']);

            $acciones = $this->agregarAcciones($modulo);
            $modulosHijos[] = array_merge(
                $this->generarElemento($modulo, $idPadre, (count($acciones)==0 && $this->permisoPerfil->tienePermisoModulo($modulo['id']))), 
                ['children' => $acciones]
            );
        }

        return $modulosHijos;
    }

    protected function generarElemento($elemento, $idPadre='#', $selected=false, $iconDefault='fa icon-screen-desktop')
    {
        $elemento= [
            'id'=>$idPadre.'-'.$elemento['id'],             
            'text'=>$elemento['nombre'], 
            'icon'=>!empty($elemento['icono']) ? $elemento['icono'] : $iconDefault,
            'data'=>['elemento_id'=>$elemento['id'],'padre_id'=>$idPadre]
            
        ];

        if ($selected) {
            $elemento['state'] = ['selected' => true];
        }
        return $elemento;
    }

    protected function agregarAcciones($modulo)
    {   
        $acciones = [];
        foreach ($this->listadoAcciones($modulo['acciones']) as $accion) {            
            $acciones[] = $this->generarElemento(
                $accion, $modulo['id'], $this->permisoPerfil->tienePermiso($modulo['id'], $accion['id'])
            );            
        }
        
        return $acciones;
    }

    protected function listadoAcciones($accionId, $iconAccion='icon-wrench')
    {
        if (trim($accionId)=='') {
            return [];
        }

        return $this->accionModulo->asignarIcono(
                    $this->accionModulo->obtenerAcciones(!empty($accionId) ? explode(',', $accionId) : -1), 
                    $iconAccion
                );
    }

    protected function agregarApila($id) 
    {
        $this->pilaModulos[] = $id;
    }

    protected function esModuloPadre($idModulo)
	{
		return array_search($idModulo, array_column($this->modulos, 'nodo_padre'));
	}
}
