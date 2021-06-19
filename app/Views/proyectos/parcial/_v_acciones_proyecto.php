<?php if(isset($permisos[9])): ?>
    <a href="javascript:;" 
        class="btn btn-success btn-round mr-2 jq_accion" 
        data-accion="9"
        data-control="<?=isset($acciones[9]) ? $acciones[9]['controlador'] : ''?>"
        data-metodo="<?=isset($acciones[9]) ? $acciones[9]['metodo'] : ''?>"
    >
        <span class="btn-label">
            <i class="flaticon-list"></i>
        </span>
        Ficha Técnica
    </a>
<?php endif; ?>
<?php if(isset($permisos[10])): ?>
    <a href="javascript:;" 
        class="btn btn-warning btn-round jq_accion" 
        data-accion="10"
        data-control="<?=isset($acciones[10]) ? $acciones[10]['controlador'] : ''?>"
        data-metodo="<?=isset($acciones[10]) ? $acciones[10]['metodo'] : ''?>"
    >
        <span class="btn-label">
            <i class="fas fa-film"></i>
        </span>
        Galería de Fotos y Videos
    </a>
<?php endif; ?>