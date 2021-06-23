<?php if(isset($permisos[1]) || isset($permisos[2])): ?>
    <a href="javascript:;" class="btn btn-success btn-round mr-2 jq_guardar_ficha">
        <span class="btn-label">
            <i class="fa fa-save"></i>
        </span>
        Guardar
    </a>
<?php endif; ?>
<a href="javascript:;" class="btn btn-warning btn-round jq_regresar_submodulo">
    <span class="btn-label">
        <i class="fa fa-undo"></i>
    </span>
    <?=isset($submodulo) ? 'Regresar' : 'Salir'?>
</a>