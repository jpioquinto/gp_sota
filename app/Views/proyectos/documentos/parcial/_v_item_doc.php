<div class="d-flex">
    <div class="avatar">
        <span class="avatar-title rounded-circle border border-white bg-<?=claseAvatar($seccion)?>"><?=ucfirst(substr($seccion, 0, 1))?></span>
    </div>
    <div class="flex-1 ml-3 pt-1">
        <a class="text-uppercase fw-bold mb-1 text-primary nombre-doc d-flex"><?=isset($nombre) ? $nombre : ''?> <span class="text-success pl-3"><?=isset($alias) ? $alias : ''?></span></a>
        <span class="text-muted"><?=isset($descripcion) ? $descripcion : ''?></span>
    </div>
    <div class="float-right pt-1">
        <small class="text-muted"><?=isset($creado_el) ? $creado_el : ''?></small>
    </div>
</div>
<div class="separator-dashed"></div>