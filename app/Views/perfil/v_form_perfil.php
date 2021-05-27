<link rel="stylesheet" href="js/plugin/jstree/themes/default/style.min.css" />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">
                        <?=isset($perfil['id']) ? "Editar perfil - <strong>{$perfil['nombre']}</strong>" : "Crear perfil" ?>
                    </h4>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?=isset($v_acciones) ? $v_acciones : ''?>
                    </div>
                </div>
            </div>
            <div class="card-body">                   
                <form class="jq_form_perfil">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-nombre">Nombre</label>
                                <input 
                                    type="text" id="data-nombre" name="nombre" 
                                    class="form-control" value="<?=isset($perfil['nombre']) ? $perfil['nombre']:''?>" minlength="8"
                                >
                                <small id="mensaje-nombre" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-descripcion">Descripción</label>
                                <input 
                                    type="text" id="data-descripcion" name="descripcion" 
                                    class="form-control" value="<?=isset($perfil['descripcion']) ? $perfil['descripcion']:''?>" minlength="8"
                                >
                                <small id="mensaje-descripcion" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-padre">Perfil padre</label>
                                <select name="padre" id="data-padre" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="h5">
                                <i class="fa flaticon-lock-1"></i> Permisos a Módulos
                            </span><hr />
                            <div id="jq_arbol_modulos"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/plugin/jstree/jstree.min.js"></script>
<script src="js/modulos/perfil/crear.js"></script>