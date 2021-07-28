<div class="col-sm-12 col-md-12">
    <div class="form-group">
        <label for="data-nombre">Nombre</label>
        <input 
            type="text" id="data-nombre" name="nombre" 
            class="form-control" value="<?=isset($nombre) ? $nombre : ''?>"
            required
        >                
    </div>
</div>             
<div class="col-sm-12 col-md-12">
    <div class="form-group">
        <label for="data-descripcion">Descripción</label>
        <input 
            type="text" id="data-descripcion" name="descripcion" 
            class="form-control" value="<?=isset($descripcion) ? $descripcion : ''?>"
            required
        >                
    </div>
</div>
<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label for="data-alias">Alias</label>
        <input 
            type="text" id="data-alias" name="alias" 
            class="form-control" value="<?=isset($alias) ? $alias : ''?>"
            required
        >                
    </div>
</div>
<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label for="data-cobertura">Nivel de Cobertura</label>
        <select class="form-control jq_select" name="cobertura" required>
            <?=isset($coberturas) ? $coberturas : ''?>
        </select>             
    </div>
</div> 