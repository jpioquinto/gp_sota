<span class="h5">Listado de correos agregados</span>
<table class="table mt-3 jq_tabla_correos">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tipo</th>
            <th scope="col">Correo</th>
            <th  width="10%"></th>                                        
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <div class="form-group form-floating-label">
                    <select class="form-control input-solid" id="id-tipo-correo" required>
                        <?=isset($listadoCorreos) ? $listadoCorreos : ''?>
                    </select>
                    <label for="id-tipo-correo" class="placeholder">Tipo de correo</label>
                </div>
            </td>
            <td>
                <div class="form-group">                                                        
                    <input id="id-correo" type="email" class="form-control input-solid" required>
                </div>
            </td>
            <td>
                <button class="btn btn-sm btn-default btn-muted pull-right jq_agregar_email" disabled>
                    <i class="fa fa-plus"></i> Agregar
                </button>
            </td>
            </tr>
    </tfoot>
</table>