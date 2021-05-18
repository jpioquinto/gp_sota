<!-- Modal -->
<div class="modal fade" id="jq_nuevo_pass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                        Nueva
                    </span> 
                    <span class="fw-light">
                        contraseña
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Contraseña anterior</label>
                                <input name="anterior" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Nueva contraseña</label>
                                <input name="nueva" type="text" class="form-control" minlength="8" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Repetir nueva contraseña</label>
                                <input name="copianueva" type="text" class="form-control" minlength="8" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_aceptar_cambio" class="btn btn-primary">Aceptar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>