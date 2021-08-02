<div class="row detalle-ficha">
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
        <p class="font-weight-bold">Vigencia</p>
        <p><?=isset($vigencia) ? $vigencia : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Periodo de vigencia (final)</p>
        <p><?=isset($vigencia_final) ? $vigencia_final : ''?></p>
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
        <p class="font-weight-bold">Lugar de aplicación</p>
        <p><?=isset($lugar_aplica) ? $lugar_aplica : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Palabras clave</p>
        <p><?=isset($palabra_clave) ? $palabra_clave : ''?></p>
    </div>
    <div class="col-md-4">
        <p class="font-weight-bold">Armonizado a la LGAHOTDU</p>
        <p><?=(isset($armonizado) && $armonizado==1)? 'Si' : 'No'?></p>
    </div>
    <div class="col-md-6">
        <p class="font-weight-bold">Obtenido de</p>
        <p><?=isset($url) ? $url : ''?></p>
    </div>
    <div class="col-md-6">
        <p class="font-weight-bold">Clasificacion</p>
        <p><?=isset($clasificacion) ? $clasificacion : ''?></p>
    </div>
</div>