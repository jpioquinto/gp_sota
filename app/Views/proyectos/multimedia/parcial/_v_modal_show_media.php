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
                <?=isset($v_media) ? $v_media : ''?>
            </div>
        </div>
    </div>
</div>
<!--script src="js/modulos/proyecto/form_media.js"></script-->