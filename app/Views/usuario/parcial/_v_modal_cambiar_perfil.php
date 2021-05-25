<!-- Modal -->
<div class="modal fade" id="jq_modal_nuevoperfil" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Cambiar</span> 
                    <span class="fw-light">
                        perfil
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="jq_form_usuario">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-usuario">Usuario</label>
                                <input type="text" id="data-usuario" name="usuario" class="form-control" value="<?=isset($usuario) ? $usuario : ''?>" disabled>
                                <small id="mensaje-usuario" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-perfil">Perfil</label>
                                <select name="perfil" id="data-perfil" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_guardar_perfil" class="btn btn-success">
                    <span class="btn-label"><i class="fa fa-save"></i></span> Actualizar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
