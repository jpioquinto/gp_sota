<!-- Modal -->
<div class="modal fade" id="jq_modal_accion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Nueva</span> 
                    <span class="fw-light">
                        Acción General
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
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data-coordinador">Coordinador</label>
                                <select name="coordinador" id="data-coordinador" class="form-control">
                                    <?=isset($usuarios) ? $usuarios : ''?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-ponderacion">Ponderación de Avance</label>
                                <input type="numeric" id="data-ponderacion" name="ponderacion" class="form-control" value="<?=isset($ponderacion) ? $ponderacion : ''?>">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data-orden">Orden</label>
                                <input type="numeric" id="data-orden" name="orden" class="form-control" value="<?=isset($orden) ? $orden : ''?>">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-nota">Nota</label>
                                <textarea id="data-nota" class="form-control" name="nota"><?=isset($nota) ? $nota : ''?></textarea>
                            </div>
                        </div>
                    </div> 
                    <?php if(isset($id)): ?>
                        <input type="hidden" name='id' value="<?=$id?>">
                    <?php endif; ?>                   
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_guardar_accion" class="btn btn-default">
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