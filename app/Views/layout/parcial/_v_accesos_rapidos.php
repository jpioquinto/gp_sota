<li class="nav-item dropdown hidden-caret">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="fas fa-layer-group"></i>
    </a>
    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
        <div class="quick-actions-header">
            <span class="title mb-1">Accesos directos</span>
            <span class="subtitle op-8">Ir a...</span>
        </div>
        <div class="quick-actions-scroll scrollbar-outer">
            <div class="quick-actions-items">
                <div class="row m-0">
                    <?=isset($v_acciones) ? $v_acciones : ''?>
                </div>
            </div>
        </div>
    </div>
</li>