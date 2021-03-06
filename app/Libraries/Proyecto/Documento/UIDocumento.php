<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\CProyecto;
use App\Models\{CatalogoModel};
use App\Traits\CifradoTrait;
use App\Libraries\Usuario;

use Carbon\{Carbon};
use DateTime;
use DateTimeZone;

class UIDocumento
{    
    protected $encrypter; 
    protected $proyecto;
    protected $usuario;
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
        $this->usuario = new Usuario();  
        $this->proyecto = $proyecto;      
        $this->config = $config;
        $this->config['tipo'] = isset($config['tipo']) ? str_replace(' de ', ' ', $config['tipo']) : '';

        isset($config['entrada']) ? $this->formatearEntrada($config['entrada']) : null;
        Carbon::setLocale('es');
    }

    public function obtenerListado($offset=null, $limit=null)
    {
        $html = '';
        $docs = $this->consultarDocs($offset, $limit);
        $permisos = $this->usuario->obtenerPermisosModulo('Proyecto');
        foreach ($docs as $doc) {
            $doc['permisos']  =  $permisos;            
            $doc['id']        =  base64_encode( $this->encriptar($doc['id']) );
            $doc['creado_el'] =  $this->formatoFecha($doc['creado_el']); 
            $doc['autores']   =  $this->listadarAutores($doc);
            $doc['v_seccion'] =  view("proyectos/documentos/parcial/_v_seccion_{$doc['seccion']}.php", $doc);
            $html            .=  view('proyectos/documentos/parcial/_v_item_doc.php', $doc);
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
            echo json_encode(['Solicitud'=>false, 'Error'=>'No se encontr?? el Gestor para esta acci??n.']); return; 
        }  

        $gestor = new GestorConsulta(new $clase());
        return $gestor->listado(['estatus'=>1, 'proyectoId'=>$this->proyecto->getId()], $this->busqueda(), $offset, $limit);
    }

    public function listadoPalabras($palabras)
    {
        $palabras = explode(' ', $palabras);
        $listado  = "";

        foreach ($palabras as $palabra) {
            $listado .= sprintf("<option value='%s' selected>%s</option>", $palabra, $palabra);
        }

        return $listado;
    }

    public function listado($datos, $id=null, $campo='descripcion')
    {
        $listado = "";

        foreach ($datos as $value) {
            #$selected = $this->seleccionar($id, $value['id']);#$id==$value['id'] ? 'selected' : '';
            $listado .= sprintf("<option value='%s' %s>%s</option>", $value['id'], $this->seleccionar($id, $value['id']), $value[$campo]);
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

    public function formatoFecha($fecha)
    {
        $actual =  new Carbon(new DateTime(date('Y-m-d H:i:s')), new DateTimeZone('America/Mexico_City'));
        $carbonFecha = new Carbon(new DateTime($fecha), new DateTimeZone('America/Mexico_City'));

        return $carbonFecha->diffForHumans($actual);
    }

    public function listadarAutores($doc)
    {
        $lista = []; ksort($doc);
        foreach ($doc as $campo => $valor) {
            if (strpos($campo, 'autor')===FALSE || trim($valor)=='') {
                continue;
            }
            $lista[] = $valor;
        }

        return implode(', ',$lista);
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
    
    protected function seleccionar($id=null, $valor)
    {
        if (is_array($id)) {
            return in_array($valor, $id)===TRUE ? 'selected' : '';
        }
        
        return $id==$valor ? 'selected' : '';
    }
}
