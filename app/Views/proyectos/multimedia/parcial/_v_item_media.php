<div class="col-6 col-sm-4 col-lg-2 item-foto">
    <div class="d-block mb-5 h-50">  
        <div class="foto text-center">
            <a class="text-center jq_imagen foto" href="" onClick="return false;" data-id="<?=isset($id) ? $id : 0?>">
                <img class="img-fluid img-thumbnail" src="<?=isset($ruta) ? $ruta : ''?>" alt="<?=isset($descripcion) ? $descripcion : ''?>">
                <p class="text-truncate"  data-toggle="tooltip" data-placement="bottom" data-original-title="<?=isset($nombre) ? $nombre : ''?>"><?=isset($nombre) ? $nombre : ''?></p>
            </a>        
        </div>
    </div>    
</div>