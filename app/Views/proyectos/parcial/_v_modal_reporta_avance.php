<!-- Modal -->
<div class="modal fade" id="jq_modal_carga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Editar</span> 
                    <span class="fw-light">
                        avance
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="jq_form_avance"> 
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-avance">Avance</label>
                                <input 
                                    type="number" id="data-avance" name="avance" 
                                    data-id="<?=isset($accion_id) ? $accion_id : ''?>"
                                    data-avance="<?=isset($avance) ? $avance : ''?>"
                                    class="form-control" value=""
                                />                                
                            </div>
                        </div>
                    </div>
                    <?=isset($v_elige_archivo) ? $v_elige_archivo : ''?>                 
                </form>
            </div>
            <div class="modal-footer no-bd">
                <a id="jq_aceptar_carga" class="invisible" href="" onclick="return false;"></a>
                <button type="button" id="jq_aceptar_avance" class="btn btn-default" disabled>
                    <span class="btn-label"><i class="fa fa-save"></i></span> Aceptar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/reportar_avance.js"></script>
<?php if($evidencia==1): ?>
    <script src="js/modulos/proyecto/cargar_documentos.js"></script>
<?php endif; ?>