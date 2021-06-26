<link rel="stylesheet" href="css/plugins/rowGroup.dataTables.min.css" />
<div class="content-acciones">
    <?=isset($acciones) ? $acciones : ''?>
</div>
<div class="container">
    <div class="table-responsive">
        <table id="jq_listado_acciones" class="display table table-striped table-hover tabla-listado-usuarios" >
            <thead>
                <tr>
                    <th class="text-center">Acción General</th>
                    <th class="text-center">Acción Específica</th>
                    <th class="text-center">Programa Ramo</th>
                    <th class="text-center">Responsable</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Fin</th>
                    <th class="text-center">Meta</th>
                    <th class="text-center">Avance</th>
                    <th style="width: 10%" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?=isset($listado) ? $listado : ''?>
            </tbody>
        </table>
    </div>
</div>
<div class="content-modal"></div>
<script src="js/modulos/proyecto/modulo_seguimiento.js?hash=<?=mt_rand()?>"></script>