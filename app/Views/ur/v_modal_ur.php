<!-- Modal -->
<div class="modal fade" id="jq_modal_ur" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">Nueva</span> 
                    <span class="fw-light">
                        Unidad Responsable
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="jq_form_ur">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="data-nombre">Nombre</label>
                                <input type="text" id="data-nombre" name="nombre" class="form-control" minlength="5" value="<?=isset($nombre) ? $nombre : ''?>" required>
                                <small id="mensaje-nombre" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-sigla">SIGLA</label>
                                <input type="text" id="data-sigla" name="sigla" class="form-control" value="<?=isset($sigla) ? $sigla : ''?>" required>
                                <small id="mensaje-sigla" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-carpeta">Carpeta</label>
                                <input type="text" id="data-carpeta" name="carpeta" class="form-control" value="<?=isset($carpeta) ? $carpeta : ''?>" required>
                                <small id="mensaje-carpeta" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="data-calle">Calle</label>
                                <input type="text" id="data-calle" name="calle" class="form-control" value="<?=isset($calle) ? $calle : ''?>">
                                <small id="mensaje-calle" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-ext">Num. Exterior</label>
                                <input type="text" id="data-ext" name="ext" class="form-control" value="<?=isset($ext) ? $ext : ''?>">
                                <small id="mensaje-ext" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-int">Num. Interior</label>
                                <input type="text" id="data-int" name="int" class="form-control" value="<?=isset($int) ? $int : ''?>">
                                <small id="mensaje-int" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="data-col">Colonia</label>
                                <input type="text" id="data-col" name="col" class="form-control" value="<?=isset($col) ? $col : ''?>">
                                <small id="mensaje-col" class="form-text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="data-cp">CP</label>
                                <input type="text" id="data-cp" name="cp" class="form-control" value="<?=isset($cp) ? $cp : ''?>">
                                <small id="mensaje-cp" class="form-text text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-entidad">Entidad</label>
                                <select name="entidad" id="data-entidad" class="form-control" required>
                                    <?=isset($entidades) ? $entidades : ''?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="data-municipio">Del. / Munpio.</label>
                                <select name="municipio" id="data-municipio" class="form-control" required>
                                    <?=isset($municipios) ? $municipios : ''?>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <?php if(isset($id)): ?>
                        <input type="hidden" name='id' value="<?=$id?>">
                    <?php endif; ?>                   
                </form>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="jq_guardar_ur" class="btn btn-default">
                    <span class="btn-label"><i class="fa fa-save"></i></span> <?=isset($id) ? 'Actualizar' : 'Crear'?>																					
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span class="btn-label"><i class="fa fa-window-close"></i></span> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/ur/form.js"></script>