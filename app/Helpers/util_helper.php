<?php
function getNameClass($clase)
{
    $path = explode('\\', $clase);    
	return array_pop($path);
}  

function obtenExtension($archivo)
{
    $ext = explode(".", $archivo);
    $ext = end($ext);

    return $ext == "" ? 'undefined' : trim($ext);
}

function quitaExtension($nombre)
{
    $ext = explode(".", $nombre);
    $ext = end($ext);

    return trim( str_replace(".{$ext}", "", $nombre) );
}

function limpiarCadena($cadena)
{
    return str_replace(
        ['Á','É','Í','Ó','Ú','Ü','á','é','í','ó','ú','ü','Ñ','ñ','#'],
        ['A','E','I','O','U','U','a','e','i','o','u','u','N','n','-'],
        $cadena
    );
}

function headerRegresar()
{
    return '<a href="javascript:;" class="btn btn-warning btn-round jq_regresar_submodulo">
                <span class="btn-label">
                    <i class="fa fa-undo"></i>
                </span>
                Regresar
            </a>';
}