<!-- Modal -->
<div class="modal fade" id="jq_modal_docs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Ver</span> 
                    <span class="fw-light">
                        documento(s)
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <?php if(isset($docs) && count($docs)==0): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                No se encontraron documentos.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?=isset($vistaContenedor) ? $vistaContenedor : ''?>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_aceptar_carga" class="btn btn-default d-none" disabled>
                    <span class="btn-label"><i class="fa fa-save"></i></span> Aceptar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/evidencia.js"></script>