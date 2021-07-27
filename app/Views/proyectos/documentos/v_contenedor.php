<link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/documento/documentos.css" />
<div class="row">
    <div class="col-12 col-md-6  offset-md-6">
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="entrada" placeholder="buscar...">
                <div class="input-group-append"">
                    <button class="btn btn-outline-secondary jq_buscar" type="button" id="btn-buscar">Buscar</button>
                </div>
                <div class="ml-1">
                    <select name="ficha" class="form-control">
                        <option value="0"> Todos</option>
                        <?=isset($fichas) ? $fichas : ''?>
                    </select>
                </div>
                <div class="ml-2">
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
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Listado de documentos</div>
                    <!--div class="card-tools">
                        <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
                            </li>
                        </ul>
                    </div-->
                </div>
            </div>
            <div class="card-body content-documentos">                
            </div>
        </div>
    </div>
</div>
<div class="content-modal"></div>
<script src="js/library/select2.min.js"></script>
<script src="js/modulos/proyecto/documentos.js?hash=<?=mt_rand()?>"></script>