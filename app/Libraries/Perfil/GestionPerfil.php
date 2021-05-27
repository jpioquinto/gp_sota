<?php 
namespace App\Libraries\Perfil;
use App\Traits\AccionesTrait;
use App\Models\{PerfilQuery, ModuloModel};
use  App\Libraries\Usuario;

class GestionPerfil
{	
    use AccionesTrait;

    protected $pilaModulos;
    protected $controlador;
    protected $encrypter;
	protected $usuario;	
    protected $modulos;
    
    public function __construct($controlador='')
	{
        $this->encrypter = \Config\Services::encrypter(); 
        $this->controlador = $controlador;                     
		$this->usuario = new Usuario();  
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

    public function obtenerListado()
    {                      
        $sHtml = '';
        foreach ($this->obtenerPerfiles() as $value) {
            $sHtml .= $this->generarFila($value);
        }
        return $sHtml;
    }

    protected function generarFila($perfil)
    {
        $fila = sprintf(
                "<tr data-id='%s'><td>%s</td><td>%s</td><td data-estatus='%d'>%s</td>",
                base64_encode($this->encrypter->encrypt($perfil['id'])), $perfil['nombre'], $perfil['descripcion'], $perfil['estatus'], 
                $this->descripcionEstatus($perfil['estatus'])
            );
        return $fila .= sprintf(
                "<td>%s</td><td>%s</td><td class='text-center'>%s</td></tr>",
                $perfil['creado_el'], $perfil['nickname'], $this->obtenerAcciones($perfil['estatus'])
            );
    }

    protected function descripcionEstatus($estatus)
    {
        if ($estatus!=2) {
            return '<span class="badge badge-dark">Activo</span>';
        }
        return '<span class="badge badge-warning">Inactivo</span>';
    }

    protected function obtenerAccionesModulo($estatus)
    {
        $acciones = $this->obtenerAccion(2, $estatus);
        return $acciones.= $this->obtenerAccion(5, $estatus);
    }

    protected function obtenerVistaAcciones()
    {
        return [2=>'_v_btn_editar', 5=>'_v_btn_habilita'];
    }

    protected function infoAccion($accion, $estatus)
    {
        if ($accion==5) {
            return [
                'mensaje'=>$estatus==1 ? 'Inhabilitar perfil' : 'Habilitar perfil',
                'clase'=>$estatus==1 ? 'minus-circle' : 'check-circle'
            ];
        }
        return [];
    }

    protected function vistaRelativaAcciones()
    {
        return 'perfil/parcial/';
    }

    protected function obtenerPerfiles()
    {
        $perfilModel = new PerfilQuery();

        return $perfilModel->listarPerfiles();
    }    

    protected function obtenerModulo($modulo)
    {
        $this->agregarElemento($modulo['id']);

        $itemModulo = ['id'=>$modulo['id'], 'parent'=>'#', 'text'=>$modulo['nombre'], 'icon'=>!empty($modulo['icono']) ? $modulo['icono'] : 'fa icon-screen-desktop'];
        if ($this->esModuloPadre($modulo['id'])===FALSE) {
            return [$itemModulo];
        }

        return array_merge([$itemModulo], $this->obtenerModulosHijos($modulo['id']));
    }

    protected function obtenerModulosHijos($idPadre)
    {
        $modulosHijos = [];
        foreach ($this->modulos as $modulo) {
            if ($modulo['nodo_padre']!=$idPadre || in_array($modulo['id'], $this->pilaModulos)) {
				continue;
			}

            $this->agregarElemento($modulo['id']);
            $modulosHijos[] = ['id'=>$modulo['id'], 'parent'=>$idPadre, 'text'=>$modulo['nombre'], 'icon'=>!empty($modulo['icono']) ? $modulo['icono'] : 'fa icon-screen-desktop'];
        }

        return $modulosHijos;
    }

    protected function agregarElemento($id) 
    {
        $this->pilaModulos[] = $id;
    }

    protected function esModuloPadre($idModulo)
	{
		return array_search($idModulo, array_column($this->modulos, 'nodo_padre'));
	}
}
