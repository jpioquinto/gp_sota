<!DOCTYPE html>
<html lang="es-mx">
<head>
	<title>Seguimiento para Proyectos del Ramo | SOTA</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=9" >
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="keywords" content="Proyectos del ramo, subsecretaría de ordenamiento territorial y agrario.">
	<meta name="description" content="Seguimiento de proyectos">
	<meta name="robots" content="none|index|follow">
	<link href='images/favicon/favicon.png' rel='shortcut icon'>
	<link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Open+Sans:600'>
    
	<!-- CSS Files -->
	<link rel="stylesheet" href="css/plugin/bootstrap.min.css">
	<link rel="stylesheet" href="css/plugin/atlantis.min.css">
	<link rel="stylesheet" href="css/plugins/animate.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/login/util.css">
	<link rel="stylesheet" type="text/css" href="css/login/main.css">
	<style>
		.hide{
			opacity:0;
		}
	</style>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-43 leyenda">
						Inicie sesión para continuar
					</span>
					<div class="wrap-input100 validate-input" data-validate = "">
						<input class="input100" type="text" name="usuario" id="usuario">
						<span class="focus-input100"></span>
						<span class="label-input100">Usuario</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="">
						<input class="input100" type="password" name="pass" id="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Contraseña</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
						</div>
						<div>
							<a href="" onClick="return false;" class="txt1 leyenda">
								¿Olvidaste tu contraseña?
							</a>
						</div>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="btn_logino">
							Ingresar
						</button>
					</div>
				</form>

				<div class="login100-more">
					<div class="content-logo">
		                <div class="content-img">
		                	<img src="images/logos/pspp.svg" class="img-fluid"/>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</div>
	<?= csrf_field() ?>
	<script src="js/library/jquery-3.6.0.min.js"></script>
	<script src="js/app/jquery.noty.packaged.min.js"></script>
	<script src="js/helpers.js"></script>
	<script src="js/util.js"></script>	
	<script src="js/modulos/login/main.js"></script>
	<script src="js/modulos/login/login.js"></script>
</body>
</html>