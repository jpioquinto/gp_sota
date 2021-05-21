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
    <!-- CSS Files -->
	<link rel="stylesheet" href="css/plugin/bootstrap.min.css">
	<link rel="stylesheet" href="css/plugin/atlantis.min.css">
	<link rel="stylesheet" href="css/plugins/animate.min.css"/>

	<!-- Fonts and icons -->
	<script src="js/plugin/webfont/webfont.min.js"></script>
    <script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['css/plugin/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<script src="js/library/jquery-3.6.0.min.js"></script>
	<script src="js/plugins/jquery.noty.packaged.min.js"></script>	
	<script src="js/helpers.js"></script>
	<script src="js/util.js"></script>
</head>
<body>
    <div class="wrapper">
        <?=isset($v_header) ? $v_header : ''?>
        <?=isset($v_sidebar) ? $v_sidebar : ''?>

        <div class="main-panel">
			<div class="content">
			<?=isset($v_perfil) ? $v_perfil : ''?>
            
            </div>
        </div>
		<?= csrf_field() ?>
    </div>	
    <!--   Core JS Files   -->
	<!--script src="js/core/jquery.3.2.1.min.js"></script-->
    <!--script src="js/library/jquery-3.6.0.min.js"></script-->
	<script src="js/core/popper.min.js"></script>
	<script src="js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="js/atlantis.min.js"></script>

	<script src="js/main.js"></script>
</body>
</html>