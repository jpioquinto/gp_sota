<?php 
namespace App\Libraries\Usuario;
use App\Models\CatalogoModel;
use  App\Libraries\Usuario;

class Perfil
{	
	protected $usuario;	

	public function __construct()
	{
		$this->usuario = new Usuario();
        
	}

	public function obtenerVistaPerfil()
	{
		$datos['v_acciones'] = view('usuario/parcial/_v_acciones');
		$datos['v_correos'] = view('usuario/parcial/_v_correos', ['listadoCorreos'=>$this->listadoTipo('cat_tipo_correos', '*')]);
		$datos['v_telefonos'] = view('usuario/parcial/_v_telefonos', ['listadoTels'=>$this->listadoTipo('cat_tipo_telefonos', '*')]);
		$datos['listadoEstados'] = $this->listadoEstados();
		$datos['listadoPuestos'] = $this->listadoPuestos();
		return view('usuario/v_perfil', $datos);
	}

	public function listadoEstados()
	{
		$strHtml = '';
		foreach ($this->getCatalogo('gp_estados', '*', 1) as $registro) {
			$strHtml .= sprintf("<option value='%d'>%s</option>", $registro['id'], $registro['estado']);
		}
		return $strHtml;
	}

	public function listadoPuestos()
	{
		$strHtml = '<option value=0></option>';
		foreach ($this->getCatalogo('cat_puestos', '*', 1) as $registro) {
			$strHtml .= sprintf("<option value='%d'>%s</option>", $registro['id'], $registro['puesto']);
		}
		return $strHtml;
	}

	public function listadoTipo($tabla, $campos, $estatus=1)
	{
		$strHtml = '';
		foreach ($this->getCatalogo('cat_tipo_correos', '*', 1) as $registro) {
			$strHtml .= sprintf("<option value='%d'>%s</option>", $registro['id'], $registro['tipo']);
		}
		return $strHtml;
	}

	public function getCatalogo($tabla, $campos='*', $estatus=null)
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo($tabla, $campos, $estatus);
    }
}