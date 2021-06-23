<link rel="stylesheet" href="css/plugins/select2.min.css" />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">
                        <?=isset($proyecto['id']) ? "Editar Ficha Técnica" : "<strong>Crear Ficha Técnica</strong>"?>
                    </h4>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?=isset($v_acciones) ? $v_acciones : ''?>
                    </div>
                </div>
            </div>
            <div class="card-body">                   
                <form class="jq_form_proyecto">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="text-center">
                                <img src="images/fondos/image-not-found-thumbnail.png" class="rounded img-fluid img-thumbnail jq_foto_proyecto" alt="Foto representativa del proyecto">
                                <span>
                                    <button class="btn btn-primary btn-sm jq_cargar_foto">
                                        <span class="btn-label">
                                            <i class="fa fa-image"></i>
                                        </span>
                                        Cargar imagen
                                    </button>
                                    <input type="file" accept=".jpg,.png" class="form-control invisible uploadFile" name="foto" value="" />
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-nombre">Nombre</label>
                                        <input 
                                            type="text" id="data-nombre" name="nombre" 
                                            class="form-control" value="<?=isset($proyecto['nombre']) ? $proyecto['nombre']:''?>" minlength="3"
                                        >
                                        <small id="mensaje-nombre" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-alias">Alias</label>
                                        <input 
                                            type="text" id="data-alias" name="alias" 
                                            class="form-control" value="<?=isset($proyecto['alias']) ? $proyecto['alias']:''?>" minlength="8"
                                        >
                                        <small id="mensaje-alias" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-descripcion">Descripción</label>
                                        <input 
                                            type="text" id="data-descripcion" name="descripcion" 
                                            class="form-control" value="<?=isset($proyecto['descripcion']) ? $proyecto['descripcion']:''?>" minlength="8"
                                        >
                                        <small id="mensaje-descripcion" class="form-text text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-tipo">Tipo proyecto</label>
                                        <select name="tipo" id="data-tipo" class="form-control">
                                            <?=isset($v_listado_tipos) ? $v_listado_tipos : ''?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-claves">Palabras clave</label>
                                        <input 
                                            type="text" id="data-claves" name="claves" 
                                            class="form-control" value="<?=isset($proyecto['palabra_clave']) ? $proyecto['palabra_clave']:''?>" minlength="8"
                                        >
                                        <small id="mensaje-claves" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-objetivo">Objetivo del Ramo 15</label>
                                        <input 
                                            type="text" id="data-objetivo" name="objetivo" 
                                            class="form-control" value="<?=isset($proyecto['objetivo']) ? $proyecto['objetivo']:''?>" minlength="8"
                                        >
                                        <small id="mensaje-objetivo" class="form-text text-danger"></small>
                                    </div>
                                </div> 

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-cobertura">Cobertura geográfica (escala)</label>
                                        <select name="cobertura" id="data-cobertura" class="form-control">
                                        <?=isset($v_listado_cobertura) ? $v_listado_cobertura : ''?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-incorporacion">Fecha de incorporación PSPP</label>
                                        <input 
                                            type="date" id="data-incorporacion" name="incorporacion" 
                                            class="form-control" value="<?=isset($proyecto['fecha_incorporacion']) ? $proyecto['fecha_incorporacion']:''?>" minlength="10"
                                        >
                                        <small id="mensaje-incorporacion" class="form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="data-nota">Nota</label>
                                        <input 
                                            type="text" id="data-nota" name="nota" 
                                            class="form-control" value="<?=isset($proyecto['nota']) ? $proyecto['nota']:''?>" minlength="8"
                                        >
                                        <small id="mensaje-nota" class="form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>                        
                        </div>                        
                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-coordinador">Coordinador Ramo 15</label>
                                <select name="coordinador" id="data-coordinador" class="form-control">
                                    <?=isset($v_listado_coordinadores) ? $v_listado_coordinadores : ''?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-responsable">Responsable</label>
                                <select name="responsable" id="data-responsable" class="form-control">
                                    <?=isset($v_listado_responsables) ? $v_listado_responsables : ''?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-colaboradores">Colaboradores</label>
                                <select name="colaboradores" id="data-colaboradores" class="form-control" multiple>
                                    <?=isset($v_listado_colaboradores) ? $v_listado_colaboradores : ''?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <?php if(isset($id)): ?>
                    <input type="hidden" name='id' value="<?=$id?>">
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/library/select2.min.js"></script>
<script src="js/modulos/proyecto/form_crear.js"></script>