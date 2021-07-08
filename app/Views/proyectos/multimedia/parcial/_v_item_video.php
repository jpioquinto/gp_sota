<div class="col-6 col-sm-12 col-lg-4">
    <div class="embed-responsive embed-responsive-16by9">
        <video controls>
            <source src="<?=isset($ruta) ? $ruta : ''?>">
            <h4>Tu navegador no soporta video</h4>
        </video>
    </div>
    <div class="alert alert-success" role="alert">
        <a class="text-center jq_video" href="" onClick="return false;" data-id="<?=isset($id) ? $id : 0?>">
            <p 
                class="text-truncate"  
                data-toggle="tooltip" 
                data-placement="bottom" 
                data-original-title="<?=isset($nombre) ? $nombre : ''?>"
            ><?=isset($nombre) ? $nombre : ''?></p>
        </a>        
    </div>    
</div>