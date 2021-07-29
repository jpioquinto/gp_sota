<form class="ficha-form" data-ficha="<?=isset($ficha) ? $ficha : ''?>">
    <div class="row"> 
        <?=isset($_v_nombre_doc) ? $_v_nombre_doc : ''?>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-tema1">Tema 1</label>
                <input 
                    type="text" id="data-tema1" name="tema1" 
                    class="form-control" value="<?=isset($doc['tema1']) ? $doc['tema1']:''?>"
                    required
                >                
            </div>
        </div>    
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-tema2">Tema 2</label>
                <input 
                    type="text" id="data-tema2" name="tema2" 
                    class="form-control" value="<?=isset($doc['tema2']) ? $doc['tema2']:''?>"
                >                
            </div>
        </div>   
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-publicado">Año de Publicación</label>
                <input 
                    type="number" id="data-publicado" name="publicado" 
                    class="form-control" value="<?=isset($doc['anio_publicado']) ? $doc['anio_publicado']:''?>"
                    required
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-num_paginas">Vigencia</label>
                <input 
                    type="number" id="data-vigencia" name="vigencia" 
                    class="form-control" value="<?=isset($doc['vigencia']) ? $doc['vigencia']:''?>"
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
        <?=isset($_v_conjunto_datos) ? $_v_conjunto_datos : ''?>
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
                <label for="data-instrumento">Instrumento Concurrente </label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="i_si" name="instrumento" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="i_si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="i_no" name="instrumento" class="custom-control-input" value="0" checked>
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
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-unidad">Unidad de Medida</label>   
                <select class="form-control jq_select" name="unidad" required>
                    <?=isset($unidades) ? $unidades : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras Claves</label>   
                <select class="form-control jq_select" multiple="multiple" name="clave" required></select>           
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
                <label for="data-lugar">Lugar de Aplicación</label>
                <input 
                    type="text" id="data-lugar" name="lugar" 
                    class="form-control" value="<?=isset($doc['lugar_aplica']) ? $doc['lugar_aplica']:''?>"
                >                
            </div>
        </div>  
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-notas">Notas</label>
                <textarea id="data-notas" class="form-control" name="notas"><?=isset($doc['notas']) ? $doc['notas']:''?></textarea>            
            </div>
        </div>                 
    </div>
    <?php if(isset($id)): ?>
        <input type="hidden" name="id" value="<?=$id?>"/>
    <?php endif; ?>
</form>