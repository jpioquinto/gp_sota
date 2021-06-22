<!-- Modal -->
<div class="modal fade" id="jq_modal_accion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Nueva</span> 
                    <span class="fw-light">
                        Acción Específica
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="jq_form_accion">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-definicion">Definición</label>
                                <input type="text" id="data-definicion" name="definicion" class="form-control" minlength="5" value="<?=isset($definicion) ? $definicion : ''?>">
                                <small id="mensaje-definicion" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-descripcion">Descripción</label>
                                <input type="text" id="data-descripcion" name="descripcion" class="form-control" value="<?=isset($descripcion) ? $descripcion : ''?>">
                                <small id="mensaje-descripcion" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data-programa">Programa Ramo</label>
                                <input type="text" id="data-programa" name="programa" class="form-control" value="<?=isset($programa) ? $programa : ''?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data-fecha_ini">Fecha inicio</label>
                                <input type="date" id="data-fecha_ini" name="fecha_ini" class="form-control" value="<?=isset($fecha_ini) ? $fecha_ini : ''?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data-fecha_fin">Fecha fin</label>
                                <input type="date" id="data-fecha_fin" name="fecha_fin" class="form-control" value="<?=isset($fecha_fin) ? $fecha_fin : ''?>">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-responsable">Responsable</label>
                                <select name="responsable" id="data-responsable" class="form-control">
                                    <?=isset($usuarios) ? $usuarios : ''?>
                                </select>
                            </div>
                        </div>                        

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-avance">Avance</label>
                                <input type="number" id="data-avance" name="avance" class="form-control" value="<?=isset($avance) ? $avance : ''?>">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-check">
                                <label>¿Requiere evidencia?</label><br/>
                                <label class="form-radio-label">
                                    <input class="form-radio-input" type="radio" name="evidencia" value="1">
                                    <span class="form-radio-sign">Si</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" type="radio" name="evidencia" value="0" checked>
                                    <span class="form-radio-sign">No</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-meta">Meta</label>
                                <textarea id="data-meta" class="form-control" name="meta"><?=isset($meta) ? $meta : ''?></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-nota">Nota</label>
                                <textarea id="data-nota" class="form-control" name="nota"><?=isset($nota) ? $nota : ''?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="accion_id" value="<?=isset($accion_id) ? $accion_id : ''?>">  
                    <?php if(isset($id)): ?>
                        <input type="hidden" name='id' value="<?=$id?>">
                    <?php endif; ?>                   
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_guardar_subaccion" class="btn btn-default">
                    <span class="btn-label"><i class="fa fa-save"></i></span> <?=isset($id) ? 'Actualizar' : 'Crear'?>																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/form_accion.js"></script>