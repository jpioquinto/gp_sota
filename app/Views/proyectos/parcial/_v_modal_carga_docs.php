<!-- Modal -->
<div class="modal fade" id="jq_modal_carga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                                <label for="data-archivo">Documento(s)</label>
                                <input 
                                    type="file" 
                                    id="data-archivo" 
                                    name="archivo" 
                                    class="form-control"
                                    <?=isset($multiple) ? $multiple : ''?>
                                    <?=(isset($accept) && $accept!='') ? "accept='{$accept}'" : ''?>
                                >                                
                            </div>
                            <div class="progress invisible">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row content-archivos mh-100 d-none" data-spy="scroll" data-target="#jq_modal_carga" data-offset="0">                        
                        <div class="col-sm-12 col-md-12 mt-3">
                            <span class="h4 font-weight-bold">Listado de documentos</span>
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
<script src="js/modulos/proyecto/cargar_documentos.js"></script>