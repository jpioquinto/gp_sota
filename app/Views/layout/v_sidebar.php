<!-- Sidebar -->
<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?=(isset($foto) && $foto!='') ? $foto : 'images/perfiles/default.png'?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?=isset($nombre) ? $nombre : 'Capture su info. de perfil'?>
                            <span class="user-level"><?=isset($perfil) ? $perfil : 'Sin perfil'?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">Ver Perfil</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary jq_sidebar">
                <?=isset($menu) ? $menu : ''?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->