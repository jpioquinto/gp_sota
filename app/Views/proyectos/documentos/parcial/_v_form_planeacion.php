<form class="ficha-form" data-ficha="<?=isset($ficha) ? $ficha : ''?>">
    <div class="row"> 
        <?=isset($_v_nombre_doc) ? $_v_nombre_doc : ''?>      
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-publicado">Fecha de publicación</label>
                <input 
                    type="date" id="data-publicado" name="publicado" 
                    class="form-control" value="<?=isset($doc['fecha_publicado']) ? $doc['fecha_publicado']:''?>"
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-num_paginas">Número de páginas</label>
                <input 
                    type="number" id="data-num_paginas" name="paginas" 
                    class="form-control" value="<?=isset($doc['num_paginas']) ? $doc['num_paginas']:''?>"
                    required
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-pais">País</label>   
                <select class="form-control jq_select" name="pais" required>
                    <?=isset($paises) ? $paises : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-grafico">ID Geográfico</label>   
                <input 
                    type="text" id="data-grafico" name="grafico" 
                    class="form-control" value="<?=isset($doc['grafico_id']) ? $doc['grafico_id']:''?>"
                >              
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-dependencia">Institución / Dependencia</label>   
                <select id="data-dependencia" class="form-control jq_select" name="institucion" required>
                <?=isset($instituciones) ? $instituciones : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-inegi">ID Geográfico INEGI</label>   
                <input 
                    type="text" id="data-inegi" name="inegi" 
                    class="form-control" value="<?=isset($doc['grafico_inegi_id']) ? $doc['grafico_inegi_id']:''?>"
                >             
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-entidad_apf">Entidad APF</label>   
                <select class="form-control jq_select" name="entidad_apf" required>
                    <?=isset($entidadesAPF) ? $entidadesAPF : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-entidad_r">Entidad Responsable</label>   
                <input 
                    type="text" id="data-entidad_r" name="entidad_r" 
                    class="form-control" value="<?=isset($doc['entidad_r']) ? $doc['entidad_r']:''?>"
                    required
                >            
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-instrumento">Instrumento concurrente</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="i_si" name="instrumento" class="custom-control-input" value="1" <?=(isset($doc['i_concurrente']) && $doc['i_concurrente']==1) ? 'checked' : ''?>>
                    <label class="custom-control-label" for="i_si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="i_no" name="instrumento" class="custom-control-input" value="0" <?=(isset($doc['i_concurrente']) && $doc['i_concurrente']!=0) ? '' : 'checked'?>>
                    <label class="custom-control-label" for="i_no">No</label>
                </div>              
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-tipo">Tipo</label>   
                <select class="form-control jq_select" name="tipo" required>
                    <?=isset($tipos) ? $tipos : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-url">Obtenido de</label>   
                <input 
                    type="text" id="data-url" name="url" 
                    class="form-control" value="<?=isset($doc['url']) ? $doc['url']:''?>"
                    placeholder="Ejemplo: https://www.x-dominio.com/nombre-del-recurso.pdf"
                >             
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras claves</label>   
                <select class="form-control jq_select" multiple="multiple" name="clave" required></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-lugar">Lugar de aplicación</label>
                <input 
                    type="text" id="data-lugar" name="lugar" 
                    class="form-control" value="<?=isset($doc['lugar_aplica']) ? $doc['lugar_aplica']:''?>"
                >                
            </div>
        </div>  
    </div>
    <?php if(isset($id)): ?>
        <input type="hidden" name="id" value="<?=$id?>"/>
    <?php endif; ?>
</form>