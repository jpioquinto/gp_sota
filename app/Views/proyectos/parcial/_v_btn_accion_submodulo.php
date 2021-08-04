<?php if(isset($permisos[11])): ?>
    <a href="javascript:;" 
        class="btn btn-dorado btn-round mr-2 jq_accion" 
        data-accion="9"
        data-control="<?=isset($acciones[11]) ? $acciones[11]['controlador'] : ''?>"
        data-metodo="<?=isset($acciones[11]) ? $acciones[11]['metodo'] : ''?>"
    >
        <span class="btn-label">
            <i class="fas fa-wrench"></i>
        </span>
        Acciones...
    </a>
<?php endif; ?>