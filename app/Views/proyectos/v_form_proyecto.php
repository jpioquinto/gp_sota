<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">
                        <?=isset($perfil['id']) ? "Editar Ficha Técnica>" : "<strong>Crear Ficha Técnica</strong>" ?>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-alias">Alias</label>
                                <input 
                                    type="text" id="data-alias" name="alias" 
                                    class="form-control" value="<?=isset($perfil['alias']) ? $perfil['alias']:''?>" minlength="8"
                                >
                                <small id="mensaje-alias" class="form-text text-danger"></small>
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
                                <label for="data-padre">Tipo proyecto</label>
                                <select name="padre" id="data-padre" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-claves">Palabras clave</label>
                                <input 
                                    type="text" id="data-claves" name="claves" 
                                    class="form-control" value="<?=isset($perfil['claves']) ? $perfil['claves']:''?>" minlength="8"
                                >
                                <small id="mensaje-claves" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-objetivo">Objetivo del Ramo 15</label>
                                <input 
                                    type="text" id="data-objetivo" name="objetivo" 
                                    class="form-control" value="<?=isset($perfil['objetivo']) ? $perfil['objetivo']:''?>" minlength="8"
                                >
                                <small id="mensaje-objetivo" class="form-text text-danger"></small>
                            </div>
                        </div> 
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-cobertura">Cobertura geográfica (escala)</label>
                                <select name="cobertura" id="data-cobertura" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-incorporacion">Fecha de incorporación PSPP</label>
                                <input 
                                    type="text" id="data-incorporacion" name="incorporacion" 
                                    class="form-control" value="<?=isset($perfil['incorporacion']) ? $perfil['incorporacion']:''?>" minlength="8"
                                >
                                <small id="mensaje-incorporacion" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-nota">Nota</label>
                                <input 
                                    type="text" id="data-nota" name="nota" 
                                    class="form-control" value="<?=isset($perfil['nota']) ? $perfil['nota']:''?>" minlength="8"
                                >
                                <small id="mensaje-nota" class="form-text text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-coordinador">Coordinador Ramo 15</label>
                                <select name="coordinador" id="data-coordinador" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-responsable">Responsable</label>
                                <select name="responsable" id="data-responsable" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-colaboradores">Colaboradores</label>
                                <select name="colaboradores" id="data-colaboradores" class="form-control">
                                    <?=isset($perfiles) ? $perfiles : ''?>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/modulos/perfil/crear.js"></script>