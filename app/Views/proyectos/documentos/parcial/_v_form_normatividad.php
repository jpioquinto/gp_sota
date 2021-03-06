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
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-vigencia">Vigencia</label>
                <input 
                    type="number" id="data-vigencia" name="vigencia" 
                    class="form-control" value="<?=isset($doc['vigencia']) ? $doc['vigencia']:''?>"
                    required
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-vigencia_final">Periodo de vigencia (final)</label>
                <input 
                    type="number" id="data-vigencia_final" name="vigencia_final" 
                    class="form-control" value="<?=isset($doc['vigencia_final']) ? $doc['vigencia_final']:''?>"
                    required
                >                
            </div>
        </div>
        <?=isset($_v_pais_idioma) ? $_v_pais_idioma : ''?>         
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
                <label for="data-armonizado">Armonizado a la LGAHOTDU</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="a_si" name="armonizado" class="custom-control-input" value="1" <?=(isset($doc['armonizado']) && $doc['armonizado']==1) ? 'checked' : ''?>>
                    <label class="custom-control-label" for="a_si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="a_no" name="armonizado" class="custom-control-input" value="0" <?=(isset($doc['armonizado']) && $doc['armonizado']!=0) ? '' : 'checked'?>>
                    <label class="custom-control-label" for="a_no">No</label>
                </div>              
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
                <label for="data-grafico">ID Geográfico</label>
                <input 
                    type="text" id="data-grafico" name="grafico" 
                    class="form-control" value="<?=isset($doc['grafico_id']) ? $doc['grafico_id']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-clasificacion">Clasificación</label>   
                <select id="data-clasificacion" class="form-control jq_select" name="clasificacion" required>
                    <?=isset($clasificaciones) ? $clasificaciones : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-id_grafico_inegi">ID Geográfico INEGI</label>
                <input 
                    type="text" id="data-id_grafico_inegi" name="inegi" 
                    class="form-control" value="<?=isset($doc['grafico_inegi_id']) ? $doc['grafico_inegi_id']:''?>"
                >                
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
                <label for="data-clave">Palabras Claves</label>   
                <select class="form-control jq_select" multiple="multiple" name="clave" required><?=isset($palabras) ? $palabras : ''?></select>           
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