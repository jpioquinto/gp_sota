<link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/usuario/listado.css"/>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?=isset($modulo) ? $modulo : ''?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <!--li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="javascript:;">Administración</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="javascript:;">Usuarios</a>
            </li-->
            <?=isset($breadcrumbs) ? $breadcrumbs : ''?>
        </ul>
    </div>                
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Listado de Usuarios</h4>
                        <?php if (isset($permisos[1])): ?>
                        <button class="btn btn-default btn-round ml-auto jq_nuevo_usuario">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">                   
                    <div class="table-responsive">
                        <table id="jq_listado_users" class="display table table-striped table-bordered table-hover tabla-listado-usuarios" >
                            <thead>
                                <tr>
                                    <th rowspan="2">Entidad</th>
                                    <th rowspan="2">Usuario</th>
                                    <th rowspan="2">Perfil</th>
                                    <th rowspan="2">Estatus</th>
                                    <th colspan="2" class="text-center">Fechas</th>
                                    <th rowspan="2">Creador</th>
                                    <th rowspan="2" style="width: 10%">Acciones</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Registro</th>
                                    <th class="text-center">Último acceso</th>
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
<script src="js/modulos/usuario/usuario.js"></script>