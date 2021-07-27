<div class="row">
    <div class="col-md-6">
        <p class="font-weight-bold">País</p>
        <p><?=isset($pais) ? $pais : ''?></p>
    </div>    
    <div class="col-md-6">
        <p class="font-weight-bold">Nivel de Cobertura</p>
        <p><?=isset($cobertura) ? $cobertura : ''?></p>
    </div>
    <div class="col-md-6">
        <p class="font-weight-bold">Tema 1</p>
        <p><?=isset($tema1) ? $tema1 : ''?></p>
    </div>
    <div class="col-md-6">
        <p class="font-weight-bold">Tema 2</p>
        <p><?=isset($tema2) ? $tema2 : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Año de Publicación</p>
        <p><?=isset($anio_publicado) ? $anio_publicado : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Vigencia</p>
        <p><?=isset($vigencia) ? $vigencia : ''?></p>
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
        <p class="font-weight-bold">Instrumento concurrente</p>
        <p><?=(isset($i_concurrente) && $i_concurrente==1)? 'Si' : 'No'?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Conjunto de Datos </p>
        <p><?=isset($conjunto) ? $conjunto : ''?></p>
    </div>   
    <div class="col-md-4">
        <p class="font-weight-bold">Unidad </p>
        <p><?=isset($unidad) ? $unidad : ''?></p>
    </div>   
    <div class="col-md-4">
        <p class="font-weight-bold">ID Geográfico </p>
        <p><?=isset($grafico_id) ? $grafico_id : ''?></p>
    </div>  
    <div class="col-md-4">
        <p class="font-weight-bold">Lugar de aplicación</p>
        <p><?=isset($lugar_aplica) ? $lugar_aplica : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Palabras clave</p>
        <p><?=isset($palabra_clave) ? $palabra_clave : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Obtenido de</p>
        <p><?=isset($url) ? $url : ''?></p>
    </div>
    <div class="col-md-12">
        <p class="font-weight-bold">Notas</p>
        <p><?=isset($notas) ? $notas : ''?></p>
    </div>
</div>