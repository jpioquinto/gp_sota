<link rel="stylesheet" href="css/modulos/proyecto/acciones.css" />
<?php if(isset($permisos[11])): ?>
    <div class="mb-3">
        <button 
            type="button"
            data-toggle="tooltip"
            title=""  
            class="btn btn-round btn-primary btn-sm jq_nueva_accion"
            data-original-title="Agregar nueva Acción General."
        >
            <i class="fa fa-plus-circle"></i> Agregar
        </button>
    </div>
<?php endif; ?>
<div class="content-acciones">
    <?=isset($acciones) ? $acciones : ''?>
</div>
<div class="content-modal"></div>
<script src="js/modulos/proyecto/seguimiento.js?hash=<?=mt_rand()?>"></script>