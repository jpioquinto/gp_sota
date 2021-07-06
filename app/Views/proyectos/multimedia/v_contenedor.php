<link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/media/imagenes.css" />
<div class="row">
    <div class="col-12 col-md-5  offset-md-7">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="buscar...">
                <div class="input-group-append"">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button>
                </div>
                <div class="ml-4">
                    <?php if(isset($permisos[27])): ?>
                    <button class="btn btn-success jq_subir" type="button">
                        <span class="btn-label">
                            <i class="fa fa-upload"></i>
                        </span> Subir                        
                    </button>
                    <?php endif; ?>
                    <input type="file" class="d-none" name="foto" accept=".jpg, .jpeg, .png, .gif, .bmp, .webp, .tif, .tiff" multiple />
                    <input type="file" class="d-none" name="video" accept=".mpeg, .ogv, .webm, .3gp, .3g2, .avi, .flv, .mp4, .ts, .mov, .wmv" multiple />
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 col-md-">
        <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd nav-pills-icons" id="v-pills-tab-with-icon" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-picture-tab-icons" data-toggle="pill" href="#v-pills-picture-icons" role="tab" aria-controls="v-pills-picture-icons" aria-selected="true" data-media="foto">
                <i class="fas flaticon-picture"></i>
                Fotos
            </a>
            <a class="nav-link" id="v-pills-film-tab-icons" data-toggle="pill" href="#v-pills-film-icons" role="tab" aria-controls="v-pills-film-icons" aria-selected="false" data-media="video">
                <i class="fas fa-film"></i>
                Videos
            </a>
        </div>
    </div>
    <div class="col-10 col-md-10">        
        <div class="tab-content" id="v-pills-with-icon-tabContent">
            <div class="tab-pane fade show active" id="v-pills-picture-icons" role="tabpanel" aria-labelledby="v-pills-picture-tab-icons">
                <?=isset($fotos) ? $fotos : ''?>                
            </div>
            <div class="tab-pane fade" id="v-pills-film-icons" role="tabpanel" aria-labelledby="v-pills-film-tab-icons">
                <p>Aquí mis videos.</p>
            </div>
        </div>
    </div>
</div>
<div class="content-modal"></div>
<script src="js/library/select2.min.js"></script>
<script src="js/modulos/proyecto/multimedia.js?hash=<?=mt_rand()?>"></script>