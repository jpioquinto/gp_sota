<p>
    <?php if (isset($permisos[25])): ?>
        <button 
            type="button" 
            data-toggle="tooltip" 
            title="" 
            data-original-title="Actualizar avance"
            class="btn btn-icon btn-round btn-default btn-xs jq_actualiza_avance"
        >
            <i class="fas fa-pencil-alt"></i>
        </button>
    <?php endif; ?>
    <?php if (isset($permisos[26])): ?>
        <button 
            type="button"
            data-toggle="tooltip" 
            title="" 
            data-original-title="Cargar documentos" 
            class="btn btn-icon btn-round btn-primary btn-xs jq_carga_docs"
        >
            <i class="fas fa-upload"></i>
        </button>
    <?php endif; ?>

    <button 
            type="button"
            data-toggle="tooltip" 
            title="" 
            data-original-title="Ver documentos" 
            class="btn btn-icon btn-round btn-success btn-xs jq_ver_docs"
        >
            <i class="fas fa-file-alt"></i>
    </button>
</p>