<form class="ficha-planeacion">
    <div class="row"> 
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-nombre">Nombre</label>
                <input 
                    type="text" id="data-nombre" name="nombre" 
                    class="form-control" value="<?=isset($doc['nombre']) ? $doc['nombre']:''?>"
                >                
            </div>
        </div>             
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
                <label for="data-cobertura">Nivel de Cobertura</label>
                <input 
                    type="text" id="data-cobertura" name="cobertura" 
                    class="form-control" value="<?=isset($doc['cobertura']) ? $doc['cobertura']:''?>"
                >                
            </div>
        </div>  
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
                <label for="data-tema2">Tema 2</label>
                <input 
                    type="text" id="data-tema2" name="tema2" 
                    class="form-control" value="<?=isset($doc['tema2']) ? $doc['tema2']:''?>"
                >                
            </div>
        </div>   
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-dependencia">Institución / Dependencia</label>   
                <select id="data-dependencia" class="form-control" name="dependencia"></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-conjunto_datos">Conjunto de Datos</label>   
                <select id="data-conjunto_datos" class="form-control" name="conjunto_datos"></select>           
            </div>
        </div>
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
                <label for="data-num_paginas">Vigencia</label>
                <input 
                    type="number" id="data-vigencia" name="vigencia" 
                    class="form-control" value="<?=isset($doc['vigencia']) ? $doc['vigencia']:''?>"
                >                
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-url">Obtenido de</label>   
                <input 
                    type="text" id="data-url" name="url" 
                    class="form-control" value="<?=isset($doc['url']) ? $doc['url']:''?>"
                >             
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-clave">Palabras Claves</label>   
                <select class="form-control jq_p_clave" multiple="multiple" name="clave"></select>           
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
                <select class="form-control" name="tipo"></select>           
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
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-lugar">Lugar de Aplicación</label>
                <input 
                    type="text" id="data-lugar" name="lugar" 
                    class="form-control" value="<?=isset($doc['lugar_a']) ? $doc['lugar_a']:''?>"
                >                
            </div>
        </div>  
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="data-notas">Notas</label>
                <textarea id="data-notas" class="form-control" name="notas"><?=isset($doc['lugar_a']) ? $doc['notas']:''?></textarea>            
            </div>
        </div> 
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-pais">País</label>   
                <select class="form-control" name="pais"></select>           
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="data-unidad">Unidad de Medida</label>   
                <select class="form-control" name="unidad"></select>           
            </div>
        </div>
    </div>
</form>