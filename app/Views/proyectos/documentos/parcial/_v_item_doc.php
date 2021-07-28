<div class="d-flex item-doc" data-id="<?=isset($id) ? $id : ''?>">
    <div class="avatar">
        <span class="avatar-title rounded-circle border border-white bg-<?=claseAvatar($seccion)?>"><?=ucfirst(substr($seccion, 0, 1))?></span>
    </div>
    <div class="flex-1 ml-3 pt-1">
        <a 
            class="text-uppercase fw-bold mb-1 text-primary nombre-doc d-flex jq_ver_doc"
            uri="<?=isset($ruta) ? $ruta : ''?>"
            nombre="<?=isset($nombre) ? $nombre : ''?>"
            extension="<?=isset($formato) ? $formato : ''?>"
        >
            <?=isset($nombre) ? $nombre : ''?> <span class="text-success pl-3"><?=isset($alias) ? $alias : ''?></span>
        </a>
        <span class="text-muted descripcion-doc"><?=isset($descripcion) ? $descripcion : ''?></span>
    </div>
    <div class="float-right pt-1">
        <small class="text-muted1"><?=isset($creado_el) ? $creado_el : ''?></small>
    </div>    
</div>
<!-------- fila con autores y acciones --------->
<div class="d-flex">
    <div class="flex-1 ml-5 pt-1 pl-3">
        <span class="font-weight-bold autor">Autor(es): </span><small class="text-muted autor"><?=(isset($autores) && trim($autores)!='') ? $autores : '#N/E'?></small>
    </div>
    <div class="float-right pt-1 content-acciones" data-id="<?=isset($id) ? $id : ''?>" data-seccion="<?=isset($seccion) ? $seccion : ''?>">
        <?php if(isset($permisos[30])): ?>
        <a 
            href="javascript:;" 
            class="btn btn-xs btn-warning btn-round jq_editar_ficha"
            data-toggle="tooltip" 
            data-placement="left" 
            data-original-title="Editar ficha del documento"
        >
            <i class="fas fa-edit"></i>                               
        </a>
        <?php endif; ?>
        <?php if(isset($permisos[31])): ?>
        <a 
            href="javascript:;" 
            class="btn btn-xs btn-danger btn-round jq_eliminar_doc"
            data-toggle="tooltip" 
            data-placement="left" 
            data-original-title="Eliminar documento"
        >
            <i class="fas fa-trash-alt"></i>                               
        </a>
        <?php endif; ?>
    </div> 
</div>
<!-------- fin de la fila con autores y acciones --------->
<!-------- ficha del documento --------->
<div class="row pt-3 ficha" data-id="<?=isset($id) ? $id : ''?>" style="display: none;">
    <div class="col-12 col-md-12 alert alert-success">
        <div class="d-flex">
            <h3><?=isset($nombre) ? $nombre : ''?></h3>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="javascript:;" class="btn btn-xs btn-dark btn-round jq_ocultar">
                    <i class="fas fa-angle-double-up"></i>                               
                </a>
            </div>
        </div>
        <h4><?=isset($alias) ? $alias : ''?> </h4>
        <p><?=isset($descripcion) ? $descripcion : ''?></p>
        <?=isset($v_seccion) ? $v_seccion : ''?>
    </div>
</div>
<!-- fin de la vista de la ficha del documento -->
<div class="separator-dashed"></div>