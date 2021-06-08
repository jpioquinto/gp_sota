<!-- esté botón se quitó por las tabs -->

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