<?php
	if($_SESSION['privilegio_spm']!=1){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ADMINISTRADOR
	</h3>
	<p class="text-justify">
		
		Bienvenido, Para buscar al Administrador registrado en el sistema ingrese el nombre o apellido 

	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO ADMINISTRADOR</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ADMINISTRADORES</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ADMINISTRADOR</a>
		</li>
	</ul>	
</div>
<?php
	if(!isset($_SESSION['busqueda_usuario']) && empty($_SESSION['busqueda_usuario'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" method="POST" enctype="multipart/form-data" autocomplete="off" >
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué usuario estas buscando?</label>
						<input type="text" class="form-control" name="busqueda_inicial_usuario" id="inputSearch" maxlength="30">
					</div>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>
<?php }else{ ?>
<div class="container-fluid">
	<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" method="POST" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="eliminar_busqueda_usuario" value="eliminar">
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_usuario']; ?>”</strong>
					</p>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="container-fluid">
	<?php
		require_once "./controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();

		$pagina=explode("/", $_GET['views']);

		echo $ins_usuario->paginador_usuario_controlador($pagina[1],15,$_SESSION['privilegio_spm'],$_SESSION['id_spm'],$pagina[0],$_SESSION['busqueda_usuario']);
	?>
</div>
<?php } ?>