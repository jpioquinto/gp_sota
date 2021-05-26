<link rel="stylesheet" href="css/plugins/select2.min.css" />
<!--link rel="stylesheet" href="css/modulos/usuario/listado.css"/-->
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Gestión de Perfiles</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="javascript:;">Administración</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="javascript:;">Perfil</a>
            </li>
        </ul>
    </div>                
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Listado de Perfiles</h4>
                        <button class="btn btn-primary btn-round ml-auto jq_nuevo_usuario">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </button>
                    </div>
                </div>
                <div class="card-body">                   
                    <div class="table-responsive">
                        <table id="jq_listado_perfiles" class="display table table-striped table-hover tabla-listado-perfiles" >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estatus</th>
                                    <th>Estatus</th>
                                    <th colspan="2" class="text-center">Fecha creación</th>
                                    <th>Creador</th>
                                    <th style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?=isset($listado) ? $listado : ''?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="content-modal"></div>

            </div>
        </div>
    </div>
</div>
<script src="js/library/select2.min.js"></script>
<script src="js/modulos/perfil/perfil.js"></script>