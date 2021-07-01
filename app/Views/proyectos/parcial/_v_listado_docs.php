<!--div class="documentos-acciones">
	<div class="listado_docs"-->
		<?php foreach ($docs as $doc): ?>
			<div class="col-sm-4 col-md-<?=isset($col) ? $col : 4?> jq_doc_accion">
				<div class="corner"></div>
				<div class="check"></div>
				<div class="item-body">
					<a 	class="jq_ver_doc"
						uri="<?=$doc['ruta']?>"
						title="<?=mostrarDescripcionDocumento($doc['ruta'],0)?>"
					>
						<img src="<?=asignarIconoDocSeguimiento($doc['ruta'])?>">
						<p><?=mostrarDescripcionDocumento($doc['ruta'],15)?></p>
					</a>
					<?php if (isset($EliminarDoc) && $EliminarDoc): ?>
					<a
						href="javascript:;" doc="<?=$doc['id']?>" class="jq_quitar_doc"
						title="Eliminar documento"
					>
						<span class="label label-warning">Eliminar</span>
					</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<!--/div>
</div-->