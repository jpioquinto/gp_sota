<?php
namespace App\Controllers;

use App\Libraries\Proyecto\{UIProyecto, UIAccion, CProyecto, CAccion, CSubAccion};
use App\Traits\{AccionGenetalTrait, AccionEspecificaTrait};
use App\Models\{AccionEspecificaModel};
use App\Libraries\Validacion\ValidaAccion;
use  App\Libraries\Usuario;

class AccionParticular extends BaseController
{
    protected $encrypter; 
    protected $usuario;
    protected $accionEspecificaModel;

    public function __construct()
    {
        @session_start();   
        $this->usuario = new Usuario();          
        $this->encrypter = \Config\Services::encrypter(); 
        $this->accionEspecificaModel = new AccionEspecificaModel(); 
    }

    public function vistaCargarDocs()
    {
        echo json_encode([
            'Solicitud'=>true, 
            'vista'=>view('proyectos/parcial/_v_modal_carga_docs', $this->request->getPost())
        ]);
    }

    public function actualizarAvance()
    {
        if ( !$this->request->getPost('id')) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'No se recibió el Identificador de la Acción.'
            ]);
            return;
        }

        if ( !is_numeric($this->request->getPost('avance'))) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'El Avance debe ser una cantidad numérica.'
            ]);
            return;
        }

        if (!$this->actualizar(['id'=>$this->encrypter->decrypt(base64_decode($this->request->getPost('id'))), 'avance'=>$this->request->getPost('avance')])) {
            echo json_encode([
                'Solicitud'=>false, 
                'Error'=>'Error al intentar actualizar el avance.'
            ]);
            return;
        }
        echo json_encode([
            'Solicitud'=>true, 
            'Msg'=>'Avance actualizado correctamente.'
        ]);
    }

    public function actualizar($campos, $id=null)
    {
        if (isset($campos['id'])) {
            return $this->accionEspecificaModel->save($campos);
        }

        if ($id && is_numeric($id)) {
            return $this->accionEspecificaModel->update($id, $campos);
        }

        return false;
    }
}
