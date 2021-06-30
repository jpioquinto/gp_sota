<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<div class="content-acciones">
    <?=isset($acciones) ? $acciones : ''?>
</div>
<div class="container">
    <div class="table-responsive">
        <table id="jq_listado_acciones" class="display table table-striped table-hover tabla-listado-usuarios"
            data-toggle="table"
            data-search="true"            
            data-show-columns="true"
            data-show-columns-search="true"
        >
            <thead>
                <tr>
                    <th class="text-center" data-field="general">Acción General</th>
                    <th class="text-center" data-field="especifica">Acción Específica</th>
                    <th class="text-center" data-field="programa">Programa Ramo</th>
                    <th class="text-center" data-field="responsable">Responsable</th>
                    <th class="text-center" data-field="inicio">Inicio</th>
                    <th class="text-center" data-field="fin">Fin</th>
                    <th class="text-center" data-field="meta">Meta</th>
                    <th class="text-center" data-field="avance">Avance</th>
                    <th style="width: 10%" class="text-center" data-field="btn-accion" >Acciones</th>
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