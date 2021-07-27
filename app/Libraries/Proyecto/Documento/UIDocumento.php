<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\CProyecto;
use App\Models\{CatalogoModel};
use App\Traits\CifradoTrait;

class UIDocumento
{    
    protected $encrypter; 
    protected $proyecto;
    protected $config;
    protected $count;
    protected $total;

    const _SPACE_ = "App\Models\\";

    use CifradoTrait;

    public function __construct(CProyecto $proyecto, $config=[])
    {
        helper(['util', 'icons']);

        $this->encrypter = \Config\Services::encrypter();  
        $this->catalogoModel = new CatalogoModel(); 
        $this->proyecto = $proyecto;      
        $this->config = $config;
        $this->config['tipo'] = isset($config['tipo']) ? str_replace(' de ', ' ', $config['tipo']) : '';

        isset($config['entrada']) ? $this->formatearEntrada($config['entrada']) : null;
    }

    public function obtenerListado($offset=null, $limit=null)
    {
        $html = '';
        $docs = $this->consultarDocs($offset, $limit);
        foreach ($docs as $doc) {
            $doc['id'] = base64_encode( $this->encriptar($doc['id']) );
            $html .= view('proyectos/documentos/parcial/_v_item_doc.php', $doc);
        }
        $this->setCount(count($docs));

        return $html;
    }

    public function consultarDocs($offset=null, $limit=null)
    {      
        $clase = strcmp(trim($this->config['tipo']), 'Todos')===0 
                ? self::_SPACE_.'DocumentoQuery'
                : self::_SPACE_.str_replace(' ', '', ucwords(limpiarCadena($this->config['tipo']))).'Model';#var_dump($clase);exit;

        if (!class_exists($clase)) {
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontró el Gestor para esta acción.']); return; 
        }  

        $gestor = new GestorConsulta(new $clase());
        return $gestor->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId()], $this->busqueda(), $offset, $limit);
    }

    public function listado($datos, $id=null, $campo='descripcion')
    {
        $listado = "";

        foreach ($datos as $value) {
            $selected = $id==$value['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%s' %s>%s</option>", $value['id'], $selected, $value[$campo]);
        }
        return $listado;
    }

    public function getCatalogo($tabla='cat_tipo_documento', $campos='*')
    {
        return $this->catalogoModel->getCatalogo($tabla, $campos, 1);
    }

    public function formatearEntrada($entrada)
    {
        $entradas = explode(' ', $entrada);

        $cadena = [];
        
        foreach ($entradas as $val) {
            if (in_array($val, ['de','con', 'y', 'e', 'o', 'u'])) {
                continue;
            }
            $cadena[] = $val;
        }

        $this->config['cadena'] = count($cadena)>0 ? implode('|', $cadena) : '';
    }

    public function busqueda()
    {
        return isset($this->config['cadena']) ? $this->config['cadena'] : null;
    }

    public function offset()
    {
        return $this->config['pagina'] * $this->config['paginacion'];   
    }

    public function limit()
    {
        return $this->config['paginacion'];
    }   

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }        
}
