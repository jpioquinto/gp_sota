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
        <label for="data-conjunto_datos">Conjunto de Datos</label>   
        <select id="data-conjunto_datos" class="form-control jq_select" name="conjunto_datos">
            <?=isset($conjuntoDatos) ? $conjuntoDatos : ''?>
        </select>           
    </div>
</div>