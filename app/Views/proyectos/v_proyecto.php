<div class="row">
	<div class="col-md-12">        
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?=isset($proyecto['alias']) ? $proyecto['alias'] : ''?></h4>
            </div>
            <div class="card-body">
                <?=isset($modulos) ? $modulos : ''?>
            </div>
        </div>
    </div>
</div>
<script src="js/modulos/proyecto/gestion.js?hash=<?=mt_rand()?>"></script>