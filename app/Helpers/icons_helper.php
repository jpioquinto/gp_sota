<?php 

function iconosControl()
{
	return [
		"doc"=>"images/iconos/svg/word.svg",
	  	"docx"=>"images/iconos/svg/word.svg",
	  	"pdf"=>"images/iconos/svg/pdf.svg",
	  	"xls"=>"images/iconos/svg/xls.svg",
	  	"xlsx"=>"images/iconos/svg/xls.svg",
	  	"ppt"=>"images/iconos/svg/ppt.svg",
	  	"pptx"=>"images/iconos/svg/ppt.svg",
	  	"zip"=>"images/iconos/svg/zip.svg",
	  	"rar"=>"images/iconos/svg/zip.svg",
	  	"jpg"=>"images/iconos/svg/imagen.svg",
	  	"jpeg"=>"images/iconos/svg/imagen.svg",
	  	"png"=>"images/iconos/svg/imagen.svg",
	  	"tif"=>"images/iconos/svg/imagen.svg",
	  	"tiff"=>"images/iconos/svg/imagen.svg",
	  	"desconocido"=>"images/iconos/svg/desconocido.svg"
	];
}

function asignarIconoDocSeguimiento($ruta)
{
	$iconos = iconosControl();
	$ext = explode('/',$ruta);
	$ext = explode('.',end($ext));
	$ext = end($ext);
	return isset($iconos[$ext]) ? $iconos[$ext] : (isset($iconos['desconocido']) ? $iconos['desconocido'] : "");
}

function mostrarDescripcionDocumento($ruta, $longitud=24)
{
	$descripcion = explode('/', $ruta);
	$descripcion = $longitud > 0 ? substr(end($descripcion), 0,$longitud) : end($descripcion);
	return $longitud > 0 ? trim($descripcion).'...' : trim($descripcion);
}

function claseAvatar($seccion)
{
	$clases = [
		'planeacion'=>'primary',
		'normatividad'=>'info',
		'estadistica'=>'warning',
		'reunion'=>'success',
		'nota-prensa'=>'danger',
		'investigacion'=>'secondary',
	];

	return isset($clases[$seccion]) ? $clases[$seccion] : 'default';
}
