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