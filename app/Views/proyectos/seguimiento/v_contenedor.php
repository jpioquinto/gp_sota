<button type="button" class="btn btn-icon btn-round btn-primary jq_nueva_accion">
    <i class="fa fa-plus-circle"></i>
</button>
<div class="content-acciones">
    <?=isset($acciones) ? $acciones : ''?>
</div>
<div class="content-modal"></div>
<script src="js/modulos/proyecto/seguimiento.js?hash=<?=mt_rand()?>"></script>