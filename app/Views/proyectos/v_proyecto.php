<div class="row">
	<div class="col-md-12">        
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center jq_header_proyecto">
                    <h4 class="card-title"><?=isset($proyecto['alias']) ? $proyecto['alias'] : ''?></h4>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?=isset($v_acciones) ? $v_acciones : ''?>
                    </div>
                </div>

                <div class="d-none align-items-center jq_header_submodulo"></div>
            </div>
            <div class="card-body">
                <div class="content-modulos">
                    <?=isset($v_modulos) ? $v_modulos : ''?>
                </div>
                <div class="content-submodulo d-none">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/gestion.js?hash=<?=mt_rand()?>"></script>