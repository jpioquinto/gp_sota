<form class="ficha-media">
    <div class="row">        
        <div class="col-sm-12 col-md-12">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="data-media" name="<?=isset($media) ? $media : 'na'?>" accept="<?=isset($accept) ? $accept : ''?>" lang="es">
                <label class="custom-file-label" for="data-media">Seleccionar Archivo</label>
            </div>
        </div>        
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-descripcion">Descripción</label>
                <input 
                    type="text" id="data-descripcion" name="descripcion" 
                    class="form-control" value="<?=isset($media['descripcion']) ? $media['descripcion']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-autor">Autor</label>
                <input 
                    type="text" id="data-autor" name="autor" 
                    class="form-control" value="<?=isset($media['autor']) ? $media['autor']:''?>"
                >                
            </div>
        </div>
        <?php if(isset($media) && $media=='video'): ?>
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="data-publicado">Fecha de publicación</label>
                    <input 
                        type="date" id="data-publicado" name="publicado" 
                        class="form-control" value="<?=isset($media['publicado']) ? $media['publicado']:''?>"
                    >                
                </div>
            </div>
        <?php endif; ?>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-licencia">Licencia o restricción de acceso</label>
                <select id="data-licencia" name="licencia"  class="form-control">
                    <?=isset($restricciones) ? $restricciones : ''?>
                </select>              
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras claves</label>   
                <select class="form-control jq_p_clave" multiple="multiple" name="clave"></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-p_serie">Perteneciente a una serie: </label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="p_si" name="p_serie" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="p_si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="p_no" name="p_serie" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="p_no">No</label>
                </div>              
            </div>
        </div>
    </div>
</form>