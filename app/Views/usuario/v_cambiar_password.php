<!-- Modal -->
<div class="modal fade" id="jq_nuevo_pass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                        <?=isset($usuario['nickname']) ? 'Cambiar contraseña': 'Nueva'?>
                    </span> 
                    <span class="fw-light">
                        <?=isset($usuario['nickname']) ? ' de ' . $usuario['nickname']: 'contraseña'?>
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form>
                    <div class="row">
                        <?php if (!isset($usuario['nickname'])): ?>
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Contraseña anterior</label>
                                    <input name="anterior" type="password" class="form-control">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Nueva contraseña</label>
                                <input name="nueva" type="password" class="form-control" minlength="8" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Repetir nueva contraseña</label>
                                <input name="copianueva" type="password" class="form-control" minlength="8" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_aceptar_cambio" class="btn btn-dark">Aceptar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php if (isset($usuario['id'])): ?>
    <script src="js/modulos/usuario/cambiar_pass.js"></script>
<?php endif; ?>