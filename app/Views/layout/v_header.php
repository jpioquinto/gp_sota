<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="sota">   

        <a href="" class="logo" onclick="return false;">
            <img src="images/logos/logo.svg" alt="navbar brand" class="navbar-brand" style="width: 8rem; margin-top: -2%; margin-bottom: -2%; margin-left: -15%;">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="sota">
        
        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search mr-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pr-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" placeholder="Buscar ..." class="form-control">
                    </div>
                </form>
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item toggle-nav-search hidden-caret">
                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                
                <!--li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification">4</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">Tienes 4 notificaciones</div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                Nuevo usuario registrado
                                            </span>
                                            <span class="time">hace 5 minutos</span> 
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                Pablo realizó un comentario
                                            </span>
                                            <span class="time">Hace 12 minutos</span> 
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="notif-img"> 
                                            <img src="images/perfiles/default.png" alt="Imagen de perfil">
                                        </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                Juan Pérez te envió un mensaje
                                            </span>
                                            <span class="time">Hace 16 minutos</span> 
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">Ver toda las notificaciones<i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </li-->
                <?=isset($v_acciones) ? $v_acciones : ''?>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="<?=(isset($foto) && $foto!='') ? $foto : 'images/perfiles/default.png'?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="<?=(isset($foto) && $foto!='') ? $foto : 'images/perfiles/default.png'?>" alt="foto de perfil" class="avatar-img rounded"></div>
                                    <div class="u-text">
                                        <h4><?=isset($nombre) ? $nombre : ''?></h4>
                                        <p class="text-muted"><?=isset($email) ? $email : 'Sin dirección de correo'?></p>
                                        <a href="" onClick="return false;" class="btn btn-xs btn-secondary btn-sm jq_ver_perfil">Ver perfil</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <!--div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">My Balance</a>
                                <a class="dropdown-item" href="#">Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Account Setting</a-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item jq_cerrar_sesion" href="javascript:;">Cerrar sesión</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>