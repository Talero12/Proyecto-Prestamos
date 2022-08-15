<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include './vistas/inc/Link.php'; ?>
</head>
<body>
	<?php 
		$peticionAjax=false;

		require_once "./controladores/vistasControlador.php";

		$IV = new vistasControlador();
		$vista=$IV->obtener_vistas_controlador();

		if($vista=="login" || $vista=="404"){
			require_once "./vistas/contenidos/".$vista."-view.php";
		}else{

			/*-- Iniciar la sesion --*/
			session_start(['name'=>'SPM']);

			$pagina=explode("/",$_GET['views']);

			/*-- Instanciar controlador login --*/
			require_once "./controladores/loginControlador.php";
			$lc = new loginControlador();

			/*-- Forzar cierre de sesion --*/
			if(!isset($_SESSION['token_spm']) || !isset($_SESSION['usuario_spm']) || !isset($_SESSION['privilegio_spm']) || !isset($_SESSION['nombre_spm'])){
				echo $lc->forzar_cierre_sesion_controlador();
				exit();
			}
	?>
	<!-- Main container -->
	<main class="full-box main-container">
		<?php include './vistas/inc/NavLateral.php'; ?>
		

		<!-- Page content -->
		<section class="full-box page-content">
			<?php 
				include './vistas/inc/NavBar.php';

				/*-- Incluir vista --*/
				include $vista;
			?>
		</section>
	</main>
	<?php
			include './vistas/inc/LogOut.php';
		} 
		include './vistas/inc/Script.php'; 
	?>
</body>
</html>