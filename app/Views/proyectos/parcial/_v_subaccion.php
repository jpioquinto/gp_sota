<label class="blockquote blockquote-primary item-accion-especifica" data-id="<?=isset($id) ? $id : '0'?>">
    <strong class="txt-definicion-subaccion"><?=isset($definicion) ? $definicion : ''?></strong>
    <span class="ponderacion">Podenración: <?=isset($ponderacion) ? $ponderacion : '0'?></span>
    <?php if(isset($permisos[15])): ?>
    <span class="badge badge-warning btn-subaccion btn-editar" data-toggle="tooltip" title="" data-original-title="Editar esta acción específica.">Editar</span>&nbsp;
    <?php endif; ?>
    <?php if(isset($permisos[16])): ?>
    <span class="badge badge-danger btn-subaccion btn-eliminar" data-toggle="tooltip" title="" data-original-title="Eliminar esta acción específica.">Eliminar</span>
    <?php endif; ?>
</label>
<div class="alert alert-block alert-warning text-justify " style="margin-left: 20px;">
    <span class="descripcion">Descrición:</span> 
    <span class="txt-descripcion-subaccion">
        <?=isset($descripcion) ? $descripcion : ''?>
    </span> 
</div>