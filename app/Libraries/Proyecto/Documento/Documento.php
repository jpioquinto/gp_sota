<?php 
namespace App\Libraries\Proyecto\Documento;

use App\Libraries\Proyecto\CProyecto;
use App\Traits\CifradoTrait;

abstract class Documento
{
    protected $encrypter; 
    protected $usuario;

    use CifradoTrait;

    abstract public function guardar($request, CProyecto $proyecto, $archivo);

    abstract public function vistaForm();

    protected function vistaNombreDoc()
    {
        return view('proyectos/documentos/parcial/_v_nombre_doc');
    }

    protected function vistaConjuntoDatos()
    {
        return view('proyectos/documentos/parcial/_v_conjunto_datos');
    }

    protected function vistaPaisIdioma()
    {
        return view('proyectos/documentos/parcial/_v_pais_idioma');
    }
}
