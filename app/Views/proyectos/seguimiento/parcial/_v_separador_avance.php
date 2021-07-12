<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><strong>Avance reportado</strong></h5>
                    </div>
                    <h3 class="text-info fw-bold"><?=isset($avance) ? $avance : ''?>%</h3>
                </div>
                <?php if(isset($validado) && $validado==0): ?>
                    <div class="d-flex justify-content-between mt-2">
                        <p class="text-muted mb-0">
                                <span 
                                class="badge badge-warning btn-valida-avance jq_validar"
                                data-id="<?=isset($id) ? $id : ''?>"
                                ><strong>Validar</strong></span>
                        </p>
                        <!--p class="text-muted mb-0">..%</p-->
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>