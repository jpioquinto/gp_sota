<form class="ficha-form" data-ficha="<?=isset($ficha) ? $ficha : ''?>">
    <div class="row"> 
        <?php if(!isset($id)): ?>
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="data-nombre">Nombre</label>
                    <input 
                        type="text" id="data-nombre" name="nombre" 
                        class="form-control" value="<?=isset($doc['nombre']) ? $doc['nombre']:''?>"
                    >                
                </div>
            </div>   
        <?php endif; ?>          
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-descripcion">Descripción</label>
                <input 
                    type="text" id="data-descripcion" name="descripcion" 
                    class="form-control" value="<?=isset($doc['descripcion']) ? $doc['descripcion']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-alias">Alias</label>
                <input 
                    type="text" id="data-alias" name="alias" 
                    class="form-control" value="<?=isset($doc['alias']) ? $doc['alias']:''?>"
                >                
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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-autor">Autor</label>
                <input 
                    type="text" id="data-autor" name="autor" 
                    class="form-control" value="<?=isset($doc['autor']) ? $doc['autor']:''?>"
                >                
            </div>
        </div>  
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-tipo">Tipo</label>   
                <select class="form-control jq_select" name="tipo">
                    <?=isset($tipos) ? $tipos : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-pais">País</label>   
                <select class="form-control jq_select" name="pais">
                    <?=isset($paises) ? $paises : ''?>
                </select>           
            </div>
        </div>
        <?=isset($_v_conjunto_datos) ? $_v_conjunto_datos : ''?>
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
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-entidad_apf">Entidad APF</label>   
                <select class="form-control jq_select" name="entidad_apf">
                    <?=isset($entidadesAPF) ? $entidadesAPF : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-instrumento">Instrumento concurrente </label>
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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras claves</label>   
                <select class="form-control jq_select" multiple="multiple" name="clave"><?=isset($palabras) ? $palabras : ''?></select>           
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