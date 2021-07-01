<div class="visualizador_documento">
	<div class="content-documento">
		<p class="text-center"> <?=$titulo?> </p>

		<embed
			src="<?=$url?>"
			type="application/pdf"
			width="100%" style="min-height: 400px !important;"
			id="jq_contenedor_doc"
		></embed>
	</div>
</div>
<?=isset($vistaListado) ? $vistaListado : ''?>