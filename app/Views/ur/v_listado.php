<link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/ur/ur.css"/>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?=isset($modulo) ? $modulo : ''?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="" onClick="return false;">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <?=isset($breadcrumbs) ? $breadcrumbs : ''?>
        </ul>
    </div>                
    <div class="row content-listado-perfiles">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Listado de URs</h4>
                        <?php if (isset($permisos[1])): ?>
                        <button class="btn btn-default btn-round ml-auto jq_nueva_ur">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">                   
                    <div class="table-responsive">
                        <table 
                            id="jq_listado_urs" 
                            class="display table table-striped table-bordered table-hover dt-responsive tabla-listado-ur"
                        >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th data-field="nombre" data-switchable="false">Nombre</th>
                                    <th data-field="sigla" data-switchable="false">SIGLA</th>
                                    <th data-field="estatus" data-switchable="false">Estatus</th>  
                                    <th data-field="carpeta" data-switchable="false">Carpeta</th> 
                                    <th data-field="calle" data-visible="false">Calle</th>  
                                    <th data-field="ext" data-visible="false">Num. ext.</th>  
                                    <th data-field="int" data-visible="false">Num. Int.</th>  
                                    <th data-field="col" data-visible="false">Col.</th>  
                                    <th data-field="cp" data-visible="false">C.P.</th> 
                                    <th data-field="estado" data-switchable="false">Entidad</th>  
                                    <th data-field="municipio" data-switchable="false">Del./Munpio.</th>                                       
                                    <th data-field="acciones" style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=isset($listado) ? $listado : ''?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-modal d-none1">
        <!-- Aquí el contenido de la vista para editar o crear una UR -->
    </div>
</div>
<script src="js/library/select2.min.js"></script>
<script src="js/modulos/ur/ur.js"></script>