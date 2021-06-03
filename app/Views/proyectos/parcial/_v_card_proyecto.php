<div class="col-md-<?=isset($col) ? $col : 4?>">
    <div class="card card-post card-round">
        <img class="card-img-top" src="<?=isset($imagen) ? $imagen : ''?>" alt="<?=isset($descripcion) ? $descripcion : ''?>">
        <div class="card-body text-center">
            <p><?=isset($nombre) ? $nombre : ''?></p>
            <div class="separator-solid"></div>
            <div class="dropdown">                
                <button class="btn btn-primary btn-border dropdown-toggle" 
                    id="<?=isset($id) ? $id : 'dropdownMenuButton'?>" 
                    type="button" 
                    data-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false"
                >
                Ver información
                </button>
                <div class="dropdown-menu" aria-labelledby="<?=isset($id) ? $id : 'dropdownMenuButton'?>">
                    <?=isset($v_item_criterios) ? $v_item_criterios : ''?>                        
                </div>
            </div>
        </div>
    </div>
</div>