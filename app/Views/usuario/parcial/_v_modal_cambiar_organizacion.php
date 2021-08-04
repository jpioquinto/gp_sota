<!-- Modal -->
<div class="modal fade" id="jq_modal_nuevaorg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Cambiar de UR a </span> 
                    <span class="fw-light">
                        <?=isset($usuario) ? $usuario : 'usuario'?>
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
                                <label for="data-perfil">Unidad Responsable</label>
                                <select name="dependencia" id="data-dependencia" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_cambiar_organizacion" class="btn btn-success">
                    <span class="btn-label"><i class="fa fa-save"></i></span> Actualizar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/usuario/dependencia.js"></script>
