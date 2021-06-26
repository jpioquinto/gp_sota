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

    return $ext == "" ? 'undefined' : $ext;
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