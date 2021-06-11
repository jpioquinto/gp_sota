<div class="card <?=isset($clase) ? $clase : 'card-info'?> card-annoucement card-round">
    <div class="card-body text-center">
        <div class="card-opening"><?=isset($nombre) ? $nombre : ''?></div>
        <div class="card-desc">
            <span class="h6"><?=isset($descripcion) ? $descripcion : ''?></span>
        </div>
        <div class="card-detail">
            <button class="btn btn-light btn-rounded">Ver Detalle</button>
        </div>
    </div>
</div>