<div class="col-6 col-sm-4 col-lg-2">
    <div class="d-block mb-4 h-100">
        <a class="text-center jq_imagen" href="" onClick="return false;" data-id="<?=isset($id) ? $id : 0?>">
            <img class="img-fluid img-thumbnail" src="<?=isset($ruta) ? $ruta : ''?>" alt="<?=isset($descripcion) ? $descripcion : ''?>">
            <p class="text-truncate"  data-toggle="tooltip" data-placement="bottom" data-original-title="<?=isset($nombre) ? $nombre : ''?>"><?=isset($nombre) ? $nombre : ''?></p>
        </a>
    </div>    
</div>