<div class="col-6 col-sm-4 col-lg-6 jq_evidencia">
    <div class="card" extension="<?=obtenExtension($ruta)?>" url="<?=$ruta?>">
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

            <div class="text-muted d-none">
                <?php if (isset($EliminarDoc) && $EliminarDoc): ?>
                    <a
                        href="javascript:;" doc="<?=$id?>" class="jq_quitar_doc"
                        title="Eliminar documento"
                    >
                        <span class="label label-warning">Eliminar</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>