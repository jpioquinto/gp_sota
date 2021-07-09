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