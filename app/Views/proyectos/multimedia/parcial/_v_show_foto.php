<div class="card card-post card-round">
    <img class="card-img-top" src="<?=isset($ruta) ? $ruta : ''?>" alt="<?=isset($descripcion) ? $descripcion : ''?>">
    <div class="card-body">
        <div class="d-flex">
            <div class="info-post ml-2">
                <p class="username"><?=isset($nombre) ? $nombre : ''?></p>
                <p class="date text-muted"><?=isset($descripcion) ? $descripcion : ''?></p>
            </div>
        </div>
        <div class="separator-solid"></div>
        <?php if(isset($permisos[28])): ?>
            <a href="" onclick="return false;" class="btn btn-warning btn-rounded btn-sm">
                <i class="fas fa-trash-alt"></i> Eliminar
            </a>
        <?php endif; ?>
    </div>
</div>