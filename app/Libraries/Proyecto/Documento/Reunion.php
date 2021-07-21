<?php 
namespace App\Libraries\Proyecto\Documento;

class Reunion extends Documento
{

    public function guardar($request, $proyecto, $archivo)
    {

    }

    public function vistaForm()
    {
        return view('proyectos/documentos/parcial/_v_form_planeacion', []);

    }
}
