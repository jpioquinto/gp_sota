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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-autor_3">Tercer Autor</label>
                <input 
                    type="text" id="data-autor_3" name="autor_3" 
                    class="form-control" value="<?=isset($doc['autor_3']) ? $doc['autor_3']:''?>"
                >                
            </div>
        </div> 
        <?=isset($_v_pais_idioma) ? $_v_pais_idioma : ''?> 
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-tipo">Clasificación</label>   
                <select id="data-tipo" class="form-control" name="tipo"></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-detalle">Detalles de la Publicación</label>   
                <select id="data-detalle" class="form-control" name="detalle"></select>           
            </div>
        </div>
        <?=isset($_v_conjunto_datos) ? $_v_conjunto_datos : ''?>   
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-publicado">Año de Publicación</label>
                <input 
                    type="number" id="data-publicado" name="publicado" 
                    class="form-control" value="<?=isset($doc['publicado']) ? $doc['publicado']:''?>"
                >                
            </div>
        </div>        
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-num_paginas">Número de Páginas</label>
                <input 
                    type="number" id="data-num_paginas" name="num_paginas" 
                    class="form-control" value="<?=isset($doc['num_paginas']) ? $doc['num_paginas']:''?>"
                >                
            </div>
        </div> 
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-editorial">Editorial</label>
                <input 
                    type="text" id="data-editorial" name="editorial" 
                    class="form-control" value="<?=isset($doc['editorial']) ? $doc['editorial']:''?>"
                >                
            </div>
        </div> 
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-edicion">Edición</label>
                <input 
                    type="text" id="data-edicion" name="edicion" 
                    class="form-control" value="<?=isset($doc['edicion']) ? $doc['edicion']:''?>"
                >                
            </div>
        </div> 
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-isbn">ISBN</label>
                <input 
                    type="text" id="data-isbn" name="isbn" 
                    class="form-control" value="<?=isset($doc['isbn']) ? $doc['isbn']:''?>"
                >                
            </div>
        </div>       
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras Claves</label>   
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