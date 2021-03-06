<link rel="stylesheet" href="css/modulos/seguimiento/seguimiento.css" />
<div class="content-acciones">
    <?=isset($acciones) ? $acciones : ''?>
</div>
<div class="container">
    <div class="table-responsive">
        <table id="jq_listado_acciones" class="display table table-striped table-hover tabla-listado-usuarios"                      
            data-search="true"            
            data-show-columns="true"  
            data-buttons-class="default"          
        >
            <thead>
                <tr>
                    <th class="text-center" data-field="general" data-switchable="false">Acción General</th>
                    <th class="text-center" data-field="estatus" data-switchable="false">Estatus</th>
                    <th class="text-center" data-field="especifica" data-switchable="false">Acción Específica</th>
                    <th class="text-center" data-field="programa">Programa Ramo</th>
                    <th class="text-center" data-field="responsable">Responsable</th>
                    <th class="text-center" data-field="inicio">Inicio</th>
                    <th class="text-center" data-field="fin">Fin</th>
                    <th class="text-center" data-field="meta">Meta</th>
                    <th class="text-center" data-field="avance">Avance</th>
                    <th style="width: 10%" class="text-center" data-field="btn-accion"  data-switchable="false">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?=isset($listado) ? $listado : ''?>
            </tbody>            
        </table>
    </div>
    <a class="jq_subir_archivos d-none"></a>
</div>
<div class="content-modal"></div>
<script src="js/modulos/proyecto/modulo_seguimiento.js?hash=<?=mt_rand()?>"></script>