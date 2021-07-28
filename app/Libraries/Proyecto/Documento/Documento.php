<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\{CProyecto, CCargaArchivo};
use App\Libraries\Validacion\ValidaDocumento;
use App\Models\EvidenciaModel;
use App\Traits\CifradoTrait;
use App\Libraries\Usuario;

abstract class Documento
{
    protected $evidenciaModel;
    protected $uiDocumento;
    protected $validacion;
    protected $cargarDoc;
    protected $encrypter; 
    protected $proyecto;
    protected $usuario;

    const _DIRDOCS_ = 'documentos/';

    use CifradoTrait;

    abstract public function guardar($datos, $archivo);

    abstract public function vistaForm();

    public function __construct(CProyecto $proyecto)
    {
        helper('util');

        $this->encrypter      =   \Config\Services::encrypter();
        $this->uiDocumento    =   new UIDocumento($proyecto);
        $this->validacion     =   new ValidaDocumento();
        $this->evidenciaModel =   new EvidenciaModel();        
        $this->usuario        =   new Usuario();  
        $this->proyecto       =   $proyecto;
    }

    public static function getInstanciaCarga($proyecto, $dir = '')
    {
        return new CCargaArchivo($proyecto, self::_DIRDOCS_.$dir);
    }

    protected function opcionesPaises($id=151)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_paises'), $id, 'pais');  
    }

    protected function opcionesIdiomas($id=9)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_idiomas'), $id, 'idioma');  
    }

    protected function opcionesClasificaciones($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_clasificacion_docs'), $id);  
    }


    protected function opcionesInstituciones($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_instituciones'), $id);  
    }

    protected function opcionesEntidadesAPF($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_entidades_apf'), $id);  
    }

    protected function opcionesCategoriaProyecto($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_categorias'), $id);  
    }

    protected function opcionesCoberturas($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_coberturas'), $id);  
    }

    protected function opcionesUnidades($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_unidades'), $id);  
    }

    protected function opcionesConjuntoDatos($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_conjunto_datos'), $id);  
    }

    protected function opcionesRedesSociales($id=null)
    {
        return $this->uiDocumento->listado($this->uiDocumento->getCatalogo('cat_redes_sociales', 'descripcion AS id, descripcion, estatus'), $id);  
    }

    protected function vistaNombreDoc($datos = [])
    {
        return view('proyectos/documentos/parcial/_v_nombre_doc', $datos);
    }

    protected function vistaConjuntoDatos($datos = [])
    {
        return view('proyectos/documentos/parcial/_v_conjunto_datos', $datos);
    }

    protected function vistaPaisIdioma($datos = [])
    {
        return view('proyectos/documentos/parcial/_v_pais_idioma', $datos);
    }

    protected function guardarEvidencia($campos)
    {
        return $this->evidenciaModel->insert($campos);
    }
}
