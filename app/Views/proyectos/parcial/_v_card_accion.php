<div class="card" data-id="<?=isset($id) ? $id : 0?>">
    <div class="card-header" id="heading-<?=isset($id) ? $id : 0?>">
      <div class="d-flex align-items-center">
        <h5 class="card-title mr-auto">
          <a class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?=isset($id) ? $id : 0?>" aria-expanded="true" aria-controls="collapse-<?=isset($id) ? $id : 0?>">
            <?=isset($posicion) ? $posicion . ')' : ''?> <?=isset($definicion) ? $definicion : ''?>
          </a>
        </h5>
        <?php if(isset($permisos[14])): ?>
          <button 
            type="button" 
            data-toggle="tooltip" 
            title="" 
            class="btn btn-icon btn-round btn-success btn-xs jq_nueva_accion_particular"
            data-original-title="Agregar nueva Acción Específica."
          >
              <i class="fa fa-plus-circle"></i>
          </button>
        <?php endif; ?>
      </div>
    </div>

    <div id="collapse-<?=isset($id) ? $id : 0?>" class="collapse <?=(isset($first) && $first) ? 'show' : ''?>" aria-labelledby="heading-<?=isset($id) ? $id : 0?>" data-parent="#accordionExample">
      <div class="card-body">

        <label class="blockquote blockquote-primary">
          <strong><?=isset($definicion) ? $definicion : ''?></strong>
          <span class="ponderacion">Podenración: <?=isset($ponderacion) ? $ponderacion : '0'?></span>

          <?php if(isset($permisos[12])): ?>
            <span 
              class="badge badge-warning btn-accion btn-editar-accion"
              data-toggle="tooltip" 
              title="" 
              data-original-title="Editar Acción General."
            >Editar</span>&nbsp;
          <?php endif; ?>
          <?php if(isset($permisos[13])): ?>
            <span 
              class="badge badge-danger btn-accion btn-eliminar-accion"
              data-toggle="tooltip" 
              title="" 
              data-original-title="Eliminar Acción General."
            >Eliminar</span>
          <?php endif; ?>

        </label>

        <div class="alert alert-info" role="alert">          
          <label><strong>Descripción: </strong><?=isset($descripcion) ? $descripcion : ''?></label>
        </div>

        <div class="container">
          <?=isset($subacciones) ? $subacciones : ''?>
        </div>

      </div>
    </div>
</div>