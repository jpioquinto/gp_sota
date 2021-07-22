<form class="ficha-planeacion">
    <div class="row"> 
        <?=isset($_v_nombre_doc) ? $_v_nombre_doc : ''?>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-tema1">Tema 1</label>
                <input 
                    type="text" id="data-tema1" name="tema1" 
                    class="form-control" value="<?=isset($doc['tema1']) ? $doc['tema1']:''?>"
                >                
            </div>
        </div> 
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-vigencia">Vigencia</label>
                <input 
                    type="text" id="data-vigencia" name="vigencia" 
                    class="form-control" value="<?=isset($doc['vigencia']) ? $doc['vigencia']:''?>"
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-vigencia_final">Periodo de vigencia (final)</label>
                <input 
                    type="number" id="data-vigencia_final" name="vigencia_final" 
                    class="form-control" value="<?=isset($doc['vigencia_final']) ? $doc['vigencia_final']:''?>"
                >                
            </div>
        </div>
        <?=isset($_v_pais_idioma) ? $_v_pais_idioma : ''?>         
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-dependencia">Institución / Dependencia</label>   
                <select id="data-dependencia" class="form-control jq_select" name="dependencia">
                    <?=isset($instituciones) ? $instituciones : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-armonizado">Armonizado a la LGAHOTDU</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="a_si" name="armonizado" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="a_si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="a_no" name="armonizado" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="a_no">No</label>
                </div>              
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
                <label for="data-grafico">ID Geográfico</label>
                <input 
                    type="text" id="data-grafico" name="geografico" 
                    class="form-control" value="<?=isset($doc['geografico_id']) ? $doc['geografico_id']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-clasificacion">Clasificación</label>   
                <select id="data-clasificacion" class="form-control jq_select" name="clasificacion">
                    <?=isset($clasificaciones) ? $clasificaciones : ''?>
                </select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-id_grafico_inegi">ID Geográfico INEGI</label>
                <input 
                    type="text" id="data-id_grafico_inegi" name="inegi" 
                    class="form-control" value="<?=isset($doc['inegi_id']) ? $doc['inegi_id']:''?>"
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
                <label for="data-instrumento">Instrumento concurrente </label>
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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras Claves</label>   
                <select class="form-control jq_select" multiple="multiple" name="clave"></select>           
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
                    class="form-control" value="<?=isset($doc['lugar_a']) ? $doc['lugar_a']:''?>"
                >                
            </div>
        </div>    
    </div>
</form>