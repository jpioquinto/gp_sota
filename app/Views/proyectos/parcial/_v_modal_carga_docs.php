<!-- Modal -->
<div class="modal fade" id="jq_modal_carga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Cargar</span> 
                    <span class="fw-light">
                        documento(s)
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="jq_form_docss">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-usuario">Archivo</label>
                                <input type="text" id="data-usuario" name="usuario" class="form-control" placeholder="Eje. juan.perez" minlength="8">
                                <small id="mensaje-usuario" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-pass">Contraseña</label>
                                <input type="password" id="data-pass" name="password" class="form-control" minlength="minlength" disabled>
                                <small id="mensaje-password" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-copiapass">Repetir contraseña</label>
                                <input type="password" id="data-copiapass" name="copiapassword" class="form-control" minlength="8" disabled>
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
                <button type="button" id="jq_aceptar_carga" class="btn btn-default" disabled>
                    <span class="btn-label"><i class="fa fa-save"></i></span> Aceptar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>