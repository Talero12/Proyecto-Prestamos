<?php
	if($_SESSION['privilegio_spm']!=1){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ADMINISTRADORES
	</h3>
	<p class="text-justify">
		Bienvenidos, en esta Tabla Puede visualizar, actualizar y eliminar siendo el Administrador Principal con control total del sistema
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO ADMINISTRADOR</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ADMINISTRADORES</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ADMNISTRADOR</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">
	<?php
		require_once "./controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();

		$pagina=explode("/", $_GET['views']);

		echo $ins_usuario->paginador_usuario_controlador($pagina[1],15,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],"");
	?>
</div>