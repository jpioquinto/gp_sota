<?php 
namespace App\Libraries\Usuario;
use App\Models\{ContactoModel};
use App\Models\MunicipioModel;
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
		$contactoModel = new ContactoModel();
		$info = $contactoModel->find($this->usuario->getId());
	
		$datos['v_acciones'] = view('usuario/parcial/_v_acciones');
		$datos['v_correos'] = view('usuario/parcial/_v_correos', 
			[
				'listadoTipoCorreos'=>$this->listadoTipo('cat_tipo_correos', '*'), 
				'listadoCorreos'=>$this->listadoCorreos(isset($info['id']) ? $info['id'] : null)
			]
		);
		$datos['v_telefonos'] = view('usuario/parcial/_v_telefonos', 
			[
				'listadoTipoTels'=>$this->listadoTipo('cat_tipo_telefonos', '*'),
				'listadoTels'=>$this->listadoTelefonos(isset($info['id']) ? $info['id'] : null)
			]
		);
		$datos['listadoEstados'] = $this->listadoEstados(isset($info['estado_id']) ? $info['estado_id'] : null);
		$datos['listadoMunpio'] = $this->listadoMunicipios(isset($info['estado_id']) ? $info['estado_id'] : null, isset($info['municipio_id']) ? $info['municipio_id'] : null);
		$datos['listadoPuestos'] = $this->listadoPuestos(isset($info['puesto_id']) ? $info['puesto_id'] : null);
		#var_dump($contactoModel->find($this->usuario->getId()));exit;
		if ($info) {
			$datos =  array_merge($datos, $info);
		}
		return view('usuario/v_perfil', $datos);
	}

	public function listadoCorreos($idContacto=null)
	{
		$datos = $this->getCatalogo(
			'gp_correos c left join cat_tipo_correos t on(c.tipo=t.id)', 'c.*, t.tipo', 
			null, is_numeric($idContacto) ? "c.contacto_id={$idContacto} AND c.estatus=1" : null
		);
		if (!is_array($datos)) {
			return '';
		}
		$accion = '<span class="badge badge-danger btn-eliminar-email jq_eliminar_email"><i class="fa fa-minus-circle"></i></span>';
		$filas = '';
		foreach ($datos  as $index=>$registro) {
			$filas .= sprintf(
				"<tr data-id='%d'><td>%d</td><td>%s</td><td data-email='true'>%s</td><td>%s</td></tr>", $registro['id'], ($index+1), $registro['tipo'], $registro['email'], $accion
			);
		}
		return $filas;
	}

	public function listadoTelefonos($idContacto=null)
	{
		$datos = $this->getCatalogo(
			'gp_telefonos t left join cat_tipo_telefonos tt on(t.tipo=tt.id)', 't.*, tt.tipo', 
			null, is_numeric($idContacto) ? "t.contacto_id={$idContacto} AND t.estatus=1" : null
		);
		if (!is_array($datos)) {
			return '';
		}
		$accion = '<span class="badge badge-danger btn-eliminar-tel jq_eliminar_tel"><i class="fa fa-minus-circle"></i></span>';
		$filas = '';
		foreach ($datos  as $index=>$registro) {
			$desc  =  ($registro['lada'] != '' ? trim($registro['lada']) : '') . trim($registro['telefono']);
			$desc .= $registro['extension'] != '' ? ' Ext. '.$registro['extension'] : '';
			$filas .= sprintf(
				"<tr data-id='%d'><td>%d</td><td>%s</td><td data-telefono='true'>%s</td><td>%s</td></tr>", 
				$registro['id'], ($index+1), $registro['tipo'], $desc, $accion
			);
		}
		return $filas;
	}

	public function listadoEstados($idEstado=null)
	{
		$strHtml = '';
		foreach ($this->getCatalogo('gp_estados', '*', 1) as $registro) {
			$seleccionar = $idEstado==$registro['id'] ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['estado']);
		}
		return $strHtml;
	}

	public function listadoMunicipios($idEstado=null, $idMunicipio=null)
	{
		if (!$idEstado) {
			return '';
		}
		$municipio = new MunicipioModel();
		$strHtml = '';
		foreach ($municipio->getMunicipiosEstado($idEstado, '*') as $registro) {
			$seleccionar = $idMunicipio==$registro['id'] ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['municipio']);
		}
		return $strHtml;

	}

	public function listadoPuestos($idPuesto=null)
	{
		$strHtml = '<option value=0></option>';
		foreach ($this->getCatalogo('cat_puestos', '*', 1) as $registro) {
			$seleccionar = $idPuesto==$registro['id'] ? 'selected' : '';
			$strHtml .= sprintf("<option value='%d' %s>%s</option>", $registro['id'], $seleccionar, $registro['puesto']);
		}
		return $strHtml;
	}

	public function listadoTipo($tabla, $campos, $estatus=1)
	{
		$strHtml = '';
		foreach ($this->getCatalogo($tabla, $campos, $estatus) as $registro) {			
			$strHtml .= sprintf("<option value='%d'>%s</option>", $registro['id'], $registro['tipo']);
		}
		return $strHtml;
	}

	public function getCatalogo($tabla, $campos='*', $estatus=null, $filtro=null)
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo($tabla, $campos, $estatus, $filtro);
    }
}