<div class="row">
    <div class="col-md-4">
        <p class="font-weight-bold">País</p>
        <p><?=isset($pais) ? $pais : ''?></p>
    </div>    
    <div class="col-md-4">
        <p class="font-weight-bold">Idioma</p>
        <p><?=isset($idioma) ? $idioma : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Nivel de Cobertura</p>
        <p><?=isset($cobertura) ? $cobertura : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Fecha de Publicación</p>
        <p><?=isset($fecha_publicado) ? $fecha_publicado : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Número de Páginas</p>
        <p><?=isset($num_paginas) ? $num_paginas : ''?></p>
    </div>    
    <div class="col-md-4">
        <p class="font-weight-bold">Tipo</p>
        <p><?=isset($tipo) ? $tipo : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Institución / Dependencia </p>
        <p><?=isset($institucion) ? $institucion : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Entidad APF </p>
        <p><?=isset($entidad_apf) ? $entidad_apf : ''?></p>
    </div>    
    <div class="col-md-4">
        <p class="font-weight-bold">Conjunto de Datos</p>
        <p><?=isset($conjunto) ? $conjunto : ''?></p>
    </div>    
    <div class="col-md-4">
        <p class="font-weight-bold">Instrumento concurrente</p>
        <p><?=(isset($i_concurrente) && $i_concurrente==1)? 'Si' : 'No'?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Lugar de aplicación</p>
        <p><?=isset($lugar_aplica) ? $lugar_aplica : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Palabras clave</p>
        <p><?=isset($palabra_clave) ? $palabra_clave : ''?></p>
    </div>
    <div class="col-md-12">
        <p class="font-weight-bold">Obtenido de</p>
        <p><?=isset($url) ? $url : ''?></p>
    </div>
</div>