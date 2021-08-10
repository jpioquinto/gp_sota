<!--link rel="stylesheet" href="css/plugins/select2.min.css" /-->
<!--link rel="stylesheet" href="css/sidebar-setting.css" /-->
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Bienvenido</h2>
                <h5 class="text-white op-7 mb-2">Seguimiento de Proyectos <?=isset($titulo) ? $titulo : ''?></h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2 content-listado-proyectos"> 
        <?=isset($listado) ? $listado : ''?>                         
    </div>
    <!-- barra lateral derecha filtros -->
    <!--div class="custom-template">
        <div class="title">Filtro</div>
        <div class="custom-content">
            <div class="switcher">
                <div class="switch-block">
                    <div class="form-group form-floating-label">
                        <select class="form-control input-border-bottom" id="selectTipoProyecto" required>
                            <option value="">&nbsp;</option>
                            <option>Proritarios</option>
                            <option>Ramo 15</option>
                        </select>
                        <label for="selectTipoProyecto" class="placeholder">Todos los Proyectos</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-toggle">
            <i class="flaticon-settings"></i>
        </div>
    </div-->
    <!-- fin de la barra lateral derecha filtros -->
    <div class='content-modulo jq_content_modulo'></div>
</div>
<!--script src="js/sidebar-setting.js?hash=<?=mt_rand()?>"></script-->
<script src="js/modulos/proyecto/proyecto.js?hash=<?=mt_rand()?>"></script>