<div class="col-md-<?=isset($col) ? $col : 4?>">
    <div class="card card-post card-round">
        <img 
            class="card-img-top" 
            src="<?=isset($imagen) ? $imagen : 'images/fondos/image-not-found.png'?>" 
            alt="<?=isset($descripcion) ? $descripcion : ''?>"
            widthhhhhhhhhhh="389"
            heightttttttttt="246"
        />
        <div class="card-body text-center">
            <p><?=isset($alias) ? $alias : ''?></p>
            <div class="separator-solid"></div>
            <button class="btn btn-primary btn-border jq_ver_proyecto" 
                id="<?=isset($id) ? $id : 'dropdownMenuButton'?>" 
                type="button" 
            >
            Ver información
            </button>           
        </div>
    </div>
</div>