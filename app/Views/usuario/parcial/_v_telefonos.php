<span class="h5">Lista de teléfonos agregados</span>
<table class="table mt-3 jq_tabla_telefonos">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tipo</th>
            <th scope="col">Teléfono</th> 
            <th width="10%"></th>                                       
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <div class="form-group form-floating-label">
                    <select class="form-control input-solid" id="id-tipo-telefono" required>                                                        
                        <?=isset($listadoTels) ? $listadoTels : ''?>
                    </select>
                    <label for="id-tipo-telefono" class="placeholder">Tipo de tel&eacute;fono</label>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="lada" class="form-control input-solid jq_validar_numero" maxlength="4" placeholder="#lada" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="telefono" class="form-control input-solid jq_validar_numero" maxlength="8" placeholder="#teléfono" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="extension" class="form-control input-solid" maxlength="6" placeholder="#extensión" required>
                    </div>
                </div>
            </td>
            <td>
                <button class="btn btn-sm btn-default btn-muted pull-right jq_agregar_telefono" disabled>
                    <i class="fa fa-plus"></i> Agregar
                </button>
            </td>
        </tr>                                        
    </tfoot>
</table>