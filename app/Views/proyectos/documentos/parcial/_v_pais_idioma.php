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
        <label for="data-idioma">Idioma</label>   
        <select class="form-control jq_select" name="idioma" required>
            <?=isset($idiomas) ? $idiomas : ''?>
        </select>           
    </div>
</div>