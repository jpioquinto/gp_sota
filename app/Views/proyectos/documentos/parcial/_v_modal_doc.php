<!-- Modal -->
<div class="modal fade" id="jq_modal_form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Documento</span> 
                    <span class="fw-light">                        
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="data-doc" name="doc" lang="es">
                            <label class="custom-file-label" for="data-doc">Seleccionar Archivo</label>
                        </div>
                    </div> 
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="data-tipo_doc">Tipo de documento</label>
                            <select id="data-tipo_doc" name="tipo_doc"  class="form-control">
                                <?=isset($tipo_doc) ? $tipo_doc : ''?>
                            </select>              
                        </div>
                    </div>    
                </div> 
                <div class="content-form">
                    
                </div>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_aceptar_form" class="btn btn-default" disabled>
                    <span class="btn-label"><i class="fa fa-save"></i></span> Aceptar																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/form_media.js"></script>