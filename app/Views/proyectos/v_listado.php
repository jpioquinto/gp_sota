<!--link rel="stylesheet" href="css/plugins/select2.min.css" />
<link rel="stylesheet" href="css/modulos/usuario/perfil.css" /-->
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Bienvenido</h2>
                <h5 class="text-white op-7 mb-2">Seguimiento de Proyectos del Ramo.</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row mt--2 content-listado-proyectos"> 
        <?=isset($listado) ? $listado : ''?>  
        
        <!--div class="col-md-4">
            <div class="card card-post card-round">
                <img class="card-img-top" src="documentos/SOTA/2021/AIFA/fotos/aifa.png" alt="Card image cap">
                <div class="card-body text-center">
                <p>AIFA TEST</p>
                <div class="separator-solid"></div>
                    <div class="dropdown">                        
                        <button class="btn btn-primary btn-border dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ver información
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-calendar"></i>  Planeación
                            </a>
                            <div role="separator" class="dropdown-divider"></div>  
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-interface-6"></i> Acta de reuniones
                            </a>
                            <div role="separator" class="dropdown-divider"></div>  
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-file-1"></i> Documentos del ramo
                            </a>
                            <div role="separator" class="dropdown-divider"></div>  
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-graph-2"></i> Estadísticas
                            </a>
                            <div role="separator" class="dropdown-divider"></div>  
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-presentation"></i> Investigaciones
                            </a>
                            <div role="separator" class="dropdown-divider"></div>                                                      
                            <a class="dropdown-item" href="" onclick="return false;">
                                <i class="flaticon-list"></i> Ficha técnica
                            </a>  
                                                    
                        </div>
                    </div>
                </div>
            </div>
        </div-->                
    </div>
    <div class='content-modulo jq_content_modulo'></div>
</div>
<script src="js/modulos/proyecto/proyecto.js"></script>