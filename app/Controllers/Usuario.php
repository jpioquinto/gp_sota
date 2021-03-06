<?php

namespace App\Controllers;
use App\Models\{UsuarioModel, ContactoModel};
use  App\Libraries\Usuario\GestionUsuario;
use  App\Libraries\Usuario as CUsuario;
use  App\Libraries\Entidad\Dependencia;
use App\Traits\InfoVistaTrait;
use App\Models\CatalogoModel;

class Usuario extends BaseController
{
    use InfoVistaTrait;

    protected $usuario; 
    protected $encrypter;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new CUsuario();  
        $this->encrypter = \Config\Services::encrypter();              
    }

    public function index()
    {
        if (!isset($_SESSION['GP_SOTA']) || empty($_SESSION['GP_SOTA'])) {			
			return redirect()->to('/'); 
		}#echo '<pre>';print_r($this->usuario);exit;
		$gestoUser = new GestionUsuario(get_class($this));
		echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view(
                'usuario/v_listado', 
                [
                    'listado'=>$gestoUser->obtenerListado(), 
                    'permisos'=>$this->usuario->obtenerPermisosModulo(get_class($this)),
                    'breadcrumbs'=>$this->generarBreadCrumbs(get_class($this)),
                    'modulo'=>$this->nombreModulo(get_class($this))
                ])
            ]);
    }

    public function obtenerVistaNuevo()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('usuario/parcial/_v_modal_nuevousuario', ['perfiles'=>$this->listadoPerfiles()])
        ]);
    }

    public function obtenerVistaCambio()
    {
        $usuario = null;
        if ($this->request->getPost('id')) {
            $usuario = $this->obtenerUsuario( $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );
        }
        echo json_encode(['Solicitud'=>true, 'vista'=>view('usuario/v_cambiar_password', ['usuario'=>$usuario])]);
    }

    public function obtenerVistaCambiarPerfil()
    {              
        $usuario = $this->obtenerUsuario( $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );

        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('usuario/parcial/_v_modal_cambiar_perfil',
                ['perfiles'=>$this->listadoPerfiles($usuario['perfil_id']??null), 'usuario'=>$usuario['nickname']??'']
             )
        ]);
    }

    public function obtenerVistaCambiarOrganizacion()
    {
        $usuario = $this->obtenerUsuario( $id=$this->encrypter->decrypt(base64_decode($this->request->getPost('id'))) );
        $dependencias = new Dependencia();
        $contactoModel = new ContactoModel();
        $contacto = $contactoModel->find($id);
        
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('usuario/parcial/_v_modal_cambiar_organizacion',
                    [                    
                        'usuario'=>$usuario['nickname']??''
                    ]
                ),
            'organizacion'=>$contacto['organizacion_id']??null,
            'opciones'=>$dependencias->obtenerListado() 
        ]);
    }

    public function cambiarPerfil()
    {
        $userModel = new UsuarioModel();
        $update = $userModel->update( 
            $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), ['perfil_id'=>$this->request->getPost('perfil')] 
        ); 

        if ($update===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar cambiar el perfil.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Perfil cambiado correctamente.']); 
    }

    public function cambiarEstatus()
    {
        $userModel = new UsuarioModel();
        $estatus = $this->request->getPost('estatus')==1 ? 2 : 1;

        $update = $userModel->update( 
            $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), 
            ['estatus'=>$estatus] 
        ); 

        if ($update===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar '.($estatus==1?'activar':'desactivar').' el usuario.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Usuario '.($estatus==1?'activado':'desactivado').' correctamente.', 'estatus'=>$estatus]); 
    }

    public function cambiarPassword()
    {
        helper('usuario');
        if ($this->usuario->getId()<1) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar obtener el usuario.']);return;
        }
        if (trim($this->request->getPost('nueva'))!=trim($this->request->getPost('copianueva'))) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La nueva contrase??a y su confirmaci??n no coinciden.']);return;
        }        
        if (encriptarPassword($this->request->getPost('anterior')) != $this->usuario->getAttribute('password')) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La contrase??a es incorrecta.']);return;
        }

        $userModel = new UsuarioModel();        
        if($userModel->update($this->usuario->getId(), ['password'=>encriptarPassword( trim($this->request->getPost('nueva')) )])===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al cambiar la contrase??a.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'La contrase??a ha sido cambiada correctamente.']); 
    }

    public function cambiarPasswordDirecto()
    {
        helper('usuario');

        if (trim($this->request->getPost('nueva'))!=trim($this->request->getPost('copianueva'))) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La nueva contrase??a y su confirmaci??n no coinciden.']);return;
        }
        
        if (strlen(trim($this->request->getPost('nueva')))<8) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'La nueva contrase??a debe contener m??nimo 8 caracteres.']);return;
        }

        $userModel = new UsuarioModel();        
        if($userModel->update($this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), ['password'=>encriptarPassword( trim($this->request->getPost('nueva')) )])===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al cambiar la contrase??a.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'La contrase??a ha sido cambiada correctamente.']); 
    }

    public function cambiarDependencia()
    {                
        $contactoModel = new ContactoModel();
        $update = $contactoModel->update(
            $this->encrypter->decrypt(base64_decode($this->request->getPost('id'))),
            ['organizacion_id'=>$this->request->getPost('dependencia')]
        );

        if ($update===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar cambiar la dependencia.']);return;
        }
        echo json_encode(['Solicitud'=>true, 'Msg'=>'Dependencia cambiada correctamente.']); 

    }

    public function agregarUsuario()
    {
        if (!$this->request->isAJAX()) {
            redirect('/'); return;
        }
        
        $validar = $this->esSolicitudValida();
        if ($validar['Solicitud']===FALSE) {
            echo json_encode($validar);return;
        } 

        helper('usuario');
		$usuarioModel = new UsuarioModel();

		$datos = [
			'nickname'=>trim($this->request->getPost('usuario')),
			'password'=>encriptarPassword(trim($this->request->getPost('password'))),
			'perfil_id'=>$this->request->getPost('perfil'),            
			'creado_por'=>$this->usuario->getId()			
		];

        if (($id = $usuarioModel->insert($datos))===FALSE) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'Error al intentar guardar el usuario.']);return;
        }

        $contactoModel = new ContactoModel();
        $contactoModel->save(['usuario_id'=>$id, 'organizacion_id'=>$this->usuario->getOrganizacionId()]);

        echo json_encode(['Solicitud'=>true, 'Msg'=>'Usuario creado correctamente.']);
    }

    public function verficarExistencia()
    {
        $userModel = new UsuarioModel();
        $usuario = $userModel->where('nickname', $this->request->getPost('usuario'))->first();
        echo json_encode(['Solicitud'=>true, 'existe'=>isset($usuario['nickname'])]);  
    }

    public function listadoPerfiles($perfilId=null)
    {
        $listado = "<option value=''></option>";

        foreach ($this->obtenerPerfiles() as $perfil) {
            $selected = $perfilId==$perfil['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%d' %s>%s</option>", $perfil['id'], $selected, $perfil['nombre']);
        }
        return $listado;
    }

    public function obtenerUsuario($id)
    {
        $userModel = new UsuarioModel();
        return $userModel->find($id);
    }

    protected function obtenerPerfiles()
    {
        $catalogo = new CatalogoModel();

        return $catalogo->getCatalogo('gp_perfiles', '*', 1);
    }

    protected function esSolicitudValida()
    {
        $validation =  \Config\Services::validation();

        $validation->run(
            [
				'usuario'=>$this->request->getPost('usuario'),
				'password'=>$this->request->getPost('password'),
				'copiapassword'=>$this->request->getPost('copiapassword'),
				'perfil'=>$this->request->getPost('perfil')
			],
            'user'
        );
        
        if ($validation->hasError('usuario')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('usuario')];
        }
        if ($validation->hasError('password')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('password')];
        }
		if ($validation->hasError('copiapassword')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('copiapassword')];
        }
		if ($validation->hasError('perfil')) {
            return ['Solicitud'=>false, 'Error'=>$validation->getError('perfil')];
        }
        return ['Solicitud'=>true];
    }
}
