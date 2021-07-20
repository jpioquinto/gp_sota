<div class="col-6 col-sm-4 col-lg-6 jq_evidencia">
    <div class="card <?=(isset($ini) && $ini) ? 'item-seleccionado' : ''?>" 
        extension="<?=obtenExtension($ruta)?>" 
        url="<?=$ruta?>"
        bloque="<?=$bloque?>"
    >
        <div class="corner"></div>
        <div class="check"></div>
        <div class="card-body text-center">
            <img src="<?=asignarIconoDocSeguimiento($ruta)?>" class="img-fluid">
            <span 
                class="d-block text-truncate text-primary"
                data-toggle="tooltip" 
                data-placement="bottom" 
                data-original-title="<?=$descripcion?>"
            ><?=mostrarDescripcionDocumento($ruta,0)?></span>

            <?php if (isset($eliminarEvidencia) && $eliminarEvidencia): ?>
                <div class="card-text mt-2">
                    <a href="" onclick="return false;" class="btn btn-warning btn-rounded btn-xs jq_eliminar_evidencia">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>