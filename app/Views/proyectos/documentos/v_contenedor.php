<link rel="stylesheet" href="css/plugins/select2.min.css" />
<!--link rel="stylesheet" href="css/modulos/media/imagenes.css" /-->
<div class="row">
    <div class="col-12 col-md-5  offset-md-7">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="entrada" placeholder="buscar...">
                <div class="input-group-append"">
                    <button class="btn btn-outline-secondary jq_buscar" type="button" id="btn-buscar">Buscar</button>
                </div>
                <div class="ml-4">
                    <?php if(isset($permisos[27])): ?>
                    <button class="btn btn-success jq_subir" type="button">
                        <span class="btn-label">
                            <i class="fa fa-upload"></i>
                        </span> Subir                        
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12">        
        <h1>Contenido del módulo de documentos.</h1>
    </div>
</div>
<div class="content-modal"></div>
<script src="js/library/select2.min.js"></script>
<script src="js/modulos/proyecto/documentos.js?hash=<?=mt_rand()?>"></script>