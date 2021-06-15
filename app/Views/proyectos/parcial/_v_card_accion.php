<div class="card" data-id="<?=isset($id) ? $id : 0?>">
    <div class="card-header" id="heading-<?=isset($id) ? $id : 0?>">
      <div class="d-flex align-items-center">
        <h5 class="card-title">
          <a class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?=isset($id) ? $id : 0?>" aria-expanded="true" aria-controls="collapse-<?=isset($id) ? $id : 0?>">
            <?=isset($definicion) ? $definicion : ''?>
          </a>
        </h5>
        <button type="button" class="btn btn-icon btn-round ml-auto btn-success btn-xs jq_nueva_accion_particular">
            <i class="fa fa-plus-circle"></i>
        </button>
      </div>
    </div>

    <div id="collapse-<?=isset($id) ? $id : 0?>" class="collapse <?=(isset($first) && $first) ? 'show' : ''?>" aria-labelledby="heading-<?=isset($id) ? $id : 0?>" data-parent="#accordionExample">
      <div class="card-body">
        <label class="blockquote blockquote-primary"><?=isset($definicion) ? $definicion : ''?></label>
        <div class="alert alert-primary" role="alert">          
          <p><strong>Descripción: </strong><?=isset($descripcion) ? $descripcion : ''?></p>
        </div>
      </div>
    </div>
</div>