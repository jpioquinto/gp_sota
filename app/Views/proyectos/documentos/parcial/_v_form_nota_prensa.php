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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-autor">Autor</label>
                <input 
                    type="text" id="data-autor" name="autor" 
                    class="form-control" value="<?=isset($doc['autor']) ? $doc['autor']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-autor_2">Segundo Autor</label>
                <input 
                    type="text" id="data-autor_2" name="autor_2" 
                    class="form-control" value="<?=isset($doc['autor_2']) ? $doc['autor_2']:''?>"
                >                
            </div>
        </div>   
        <?=isset($_v_pais_idioma) ? $_v_pais_idioma : ''?>
        <?=isset($_v_conjunto_datos) ? $_v_conjunto_datos : ''?>  
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-publicado">Fecha de publicación</label>
                <input 
                    type="date" id="data-publicado" name="publicado" 
                    class="form-control" value="<?=isset($doc['publicado']) ? $doc['publicado']:''?>"
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-num_paginas">Número de páginas</label>
                <input 
                    type="number" id="data-num_paginas" name="num_paginas" 
                    class="form-control" value="<?=isset($doc['num_paginas']) ? $doc['num_paginas']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-entidad_apf">Entidad APF</label>   
                <select class="form-control" name="entidad_apf"></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-tipo">Tipo</label>   
                <select class="form-control" name="tipo"></select>           
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
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-redes">Redes Sociales</label>   
                <select class="form-control" name="redes"></select>           
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
    </div>
</form>