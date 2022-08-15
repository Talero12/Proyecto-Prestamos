<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
	</h3>
	<p class="text-justify">
		
		Bienvenidos al sistema de Prestamos discovery communications colombia

	</p>
</div>

<div class="full-box tile-container">
	
	<?php
		require_once "./controladores/clienteControlador.php";
		$ins_cliente = new clienteControlador();
		$total_clientes = $ins_cliente->datos_cliente_controlador("Conteo",0);
	?>
	<a href="<?php echo SERVERURL; ?>client-list/" class="tile">
		<div class="tile-tittle">Usuarios</div>
		<div class="tile-icon">
			<i class="fas fa-users fa-fw"></i>
			<p><?php echo $total_clientes->rowCount(); ?> Registrados</p>
		</div>
	</a>
	
	<?php
		require_once "./controladores/itemControlador.php";
		$ins_item = new itemControlador();
		$total_items = $ins_item->datos_item_controlador("Conteo",0);
	?>
	<a href="<?php echo SERVERURL; ?>item-list/" class="tile">
		<div class="tile-tittle">Items</div>
		<div class="tile-icon">
			<i class="fas fa-pallet fa-fw"></i>
			<p><?php echo $total_items->rowCount(); ?> Registrados</p>
		</div>
	</a>
	
	<?php
		require_once "./controladores/prestamoControlador.php";
		$ins_prestamo = new prestamoControlador();
		$total_prestamos = $ins_prestamo->datos_prestamo_controlador("Conteo_Prestamo",0);
		$total_reservaciones = $ins_prestamo->datos_prestamo_controlador("Conteo_Reservacion",0);
	?>
	<a href="<?php echo SERVERURL; ?>reservation-pending/" class="tile">
		<div class="tile-tittle">Prestamos</div>
		<div class="tile-icon">
			<i class="fas fa-hand-holding-usd fa-fw"></i>
			<p><?php echo $total_prestamos->rowCount(); ?> Registrados</p>
		</div>
	</a>

	<a href="<?php echo SERVERURL; ?>reservation-reservation/" class="tile">
		<div class="tile-tittle">Reservaciones</div>
		<div class="tile-icon">
			<i class="far fa-calendar-alt fa-fw"></i>
			<p><?php echo $total_reservaciones->rowCount(); ?> Registradas</p>
		</div>
	</a>

	<?php
	if($_SESSION['privilegio_spm']==1){
		require_once "./controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();
		$total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo",0);
	?>
	<a href="<?php echo SERVERURL; ?>user-list/" class="tile">
		<div class="tile-tittle">Administrador</div>
		<div class="tile-icon">
			<i class="fas fa-user-secret fa-fw"></i>
			<p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
		</div>
	</a>
	<?php } ?>

	<a href="<?php echo SERVERURL; ?>company/" class="tile">
		<div class="tile-tittle">Empresa</div>
		<div class="tile-icon">
			<i class="fas fa-store-alt fa-fw"></i>
			<p>&nbsp;</p>
		</div>
	</a>
	
</div>