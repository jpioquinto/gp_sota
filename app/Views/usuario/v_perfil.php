<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Información de contacto</h2>
                <h5 class="text-white op-7 mb-2">Por favor, ingrese su información de contacto.</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="javascript:;" class="btn btn-success btn-round mr-2">
                    <span class="btn-label">
                        <i class="fa fa-save"></i>
                    </span>
                    Guardar
                </a>
                <a href="javascript:;" class="btn btn-warning btn-round">
                    <span class="btn-label">
                        <i class="fa fa-undo"></i>
                    </span>
                    Salir
                </a>
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
                                <img src="images/perfiles/default.png" alt="Foto de perfil" class="img-thumbnail">
                                <span>
                                    <button class="btn btn-primary btn-sm">
                                        <span class="btn-label">
                                            <i class="fa fa-image"></i>
                                        </span>
                                        Cargar foto de perfil
                                    </button>
                                    <button class="btn btn-default btn-sm mt-1">
                                        <span class="btn-label">
                                            <i class="fa fa-unlock"></i>
                                        </span>
                                        Cambiar contraseña
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-nombre">Nombre</label>
                                        <input id="id-nombre" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-appaterno">Apellido Paterno</label>
                                        <input id="id-appaterno" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-apmaterno">Apellido Materno</label>
                                        <input id="id-apmaterno" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-estado">Estado</label>
                                        <input id="id-estado" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-municipio">Municipio</label>
                                        <input id="id-municipio" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-puesto">Puesto</label>
                                        <input id="id-puesto" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id-cargo" class="pull-right">Cargo Oficial</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">                                
                                        <input id="id-cargo" type="text" class="form-control input-solid" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr />
                                    <span class="h5">Listado de correos agregados</span>
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Correo</th>
                                                <th  width="10%"></th>                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="form-group form-floating-label">
                                                        <select class="form-control input-solid" id="id-tipo-correo" required="">
                                                            <option value="">&nbsp;</option>
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                        </select>
                                                        <label for="id-tipo-correo" class="placeholder">Tipo de correo</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">                                                        
                                                        <input id="id-correo" type="email" class="form-control input-solid" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-default btn-muted pull-right jq_agregar_email" disabled>
                                                        <i class="fa fa-plus"></i> Agregar
                                                    </button>
                                                </td>
												</tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                    <span class="h5">Lista de teléfonos agregados</span>
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Teléfono</th> 
                                                <th width="10%"></th>                                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="form-group form-floating-label">
                                                        <select class="form-control input-solid" id="id-tipo-telefono" required>                                                        
															<option value="1">Institucional</option>
                                                            <option value="5">Personal Casa</option>
                                                            <option value="2" disabled="">Personal Celular</option>
                                                            <option value="3">Personal Nextel</option>
                                                            <option value="4">Personal Oficina</option>
                                                        </select>
                                                        <label for="id-tipo-telefono" class="placeholder">Tipo de tel&eacute;fono</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control input-solid" placeholder="#lada" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control input-solid" placeholder="#teléfono" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control input-solid" placeholder="#extenasión" required>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-default btn-muted pull-right jq_agregar_telefono" disabled>
                                                        <i class="fa fa-plus"></i> Agregar
                                                    </button>
                                                </td>
                                            </tr>                                        
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>