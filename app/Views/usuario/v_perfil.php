<link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/usuario/perfil.css" />
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Información de contacto</h2>
                <h5 class="text-white op-7 mb-2">Por favor, ingrese su información de contacto.</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <?=isset($v_acciones) ? $v_acciones : ''?>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="h6">*Imagen permitida <strong class="text-warning">(.jpg y .png)</strong> en un tamańo no máximo a <strong class="text-danger">500 KB</strong></span>
                        </div>
                        <div class="col-md-2">                          
                            <div class="text-center">                  
                                <img src="<?=(isset($foto) && $foto!='') ? $foto : 'images/perfiles/default.png'?>" alt="Foto de perfil" class="img-thumbnail jq_foto_perfil">
                                <span>
                                    <button class="btn btn-dorado btn-sm jq_cargar_foto">
                                        <span class="btn-label">
                                            <i class="fa fa-image"></i>
                                        </span>
                                        Cargar foto de perfil
                                    </button>
                                    <button class="btn btn-default btn-sm mt-1 jq_cambiar_passw">
                                        <span class="btn-label">
                                            <i class="fa fa-unlock"></i>
                                        </span>
                                        Cambiar contraseña
                                    </button>
                                    <input type="file" accept=".jpg,.png" class="form-control invisible uploadFile" name="foto" value="" />
                                </span>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="row jq_formulario">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-nombre">Nombre</label>
                                        <input id="id-nombre" name="nombre" type="text" class="form-control input-solid" value="<?=isset($nombre) ? $nombre : ''?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-appaterno">Apellido Paterno</label>
                                        <input id="id-appaterno" name="ap_paterno" type="text" class="form-control input-solid" value="<?=isset($ap_paterno) ? $ap_paterno : ''?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-apmaterno">Apellido Materno</label>
                                        <input id="id-apmaterno" name="ap_materno" type="text" class="form-control input-solid" value="<?=isset($ap_materno) ? $ap_materno : ''?>" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-estado">Estado</label>                                        
                                        <select class="form-control input-solid" id="id-estado" name="estado">
                                            <?=isset($listadoEstados) ? $listadoEstados : ''?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-municipio">Municipio</label>                                    
                                        <select class="form-control input-solid" id="id-municipio" name="municipio">
                                            <?=isset($listadoMunpio) ? $listadoMunpio : ''?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-puesto">Puesto</label>                                        
                                        <select class="form-control input-solid" id="id-puesto" name="puesto">
                                            <?=isset($listadoPuestos) ? $listadoPuestos : ''?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-cargo" class="pull-right">Cargo Oficial</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">                                
                                        <input id="id-cargo" name="cargo" type="text" class="form-control input-solid" value="<?=isset($cargo) ? $cargo : ''?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr />
                                    <?=isset($v_correos) ? $v_correos : ''?>
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                    <?=isset($v_telefonos) ? $v_telefonos : ''?>
                                </div>

                                <div class="col-md-12">
                                    <div class="ml-md-auto py-2 py-md-0 pull-right">
                                        <?=isset($v_acciones) ? $v_acciones : ''?>
                                    </div>
                                </div>                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='content-modal'>
    </div>
</div>
<script src="js/library/select2.min.js"></script>
<script src="js/library/jquery.mask.min.js"></script>
<script src="js/modulos/usuario/perfil.js"></script>