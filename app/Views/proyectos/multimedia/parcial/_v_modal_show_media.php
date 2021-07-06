<!-- Modal -->
<div class="modal fade" id="jq_modal_show_media" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">Mostrando imagen</span> 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <div class="card card-post card-round">
                    <img class="card-img-top" src="<?=isset($ruta) ? $ruta : ''?>" alt="<?=isset($descripcion) ? $descripcion : ''?>">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="info-post ml-2">
                                <p class="username"><?=isset($nombre) ? $nombre : ''?></p>
                                <p class="date text-muted"><?=isset($descripcion) ? $descripcion : ''?></p>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <?php if(isset($permisos[28])): ?>
                        <a href="" onclick="return false;" class="btn btn-warning btn-rounded btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--script src="js/modulos/proyecto/form_media.js"></script-->