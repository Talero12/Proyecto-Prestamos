<?php

	session_start(['name'=>'SPM']);
	require_once "../config/APP.php";
	
	if(isset($_POST)){

		/*----------  Modulo Usuario  ----------*/
		if(isset($_POST['busqueda_inicial_usuario'])){
			if($_POST['busqueda_inicial_usuario']==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Introduce un termino de búsqueda para comenzar a buscar un usuario",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$_SESSION['busqueda_usuario']=$_POST['busqueda_inicial_usuario'];
			$url="user-search";
		}

		if(isset($_POST['eliminar_busqueda_usuario'])){
			unset($_SESSION['busqueda_usuario']);
			$url="user-search";
		}
		


		/*----------  Modulo Item  ----------*/
		if(isset($_POST['busqueda_inicial_item'])){
			if($_POST['busqueda_inicial_item']==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Introduce un termino de búsqueda para comenzar a buscar un item",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$_SESSION['busqueda_item']=$_POST['busqueda_inicial_item'];
			$url="item-search";
		}

		if(isset($_POST['eliminar_busqueda_item'])){
			unset($_SESSION['busqueda_item']);
			$url="item-search";
		}



		/*----------  Modulo Cliente  ----------*/
		if(isset($_POST['busqueda_inicial_cliente'])){
			if($_POST['busqueda_inicial_cliente']==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Introduce un termino de búsqueda para comenzar a buscar un cliente",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			$_SESSION['busqueda_cliente']=$_POST['busqueda_inicial_cliente'];
			$url="client-search";
		}

		if(isset($_POST['eliminar_busqueda_cliente'])){
			unset($_SESSION['busqueda_cliente']);
			$url="client-search";
		}



		/*----------  Modulo Prestamos  ----------*/
		if(isset($_POST['busqueda_inicio_prestamo']) || isset($_POST['busqueda_final_prestamo'])){
			if($_POST['busqueda_inicio_prestamo']=="" || $_POST['busqueda_final_prestamo']==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Introduce la fecha inicial y final de búsqueda para comenzar a buscar un préstamo",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando logica de las fechas ==*/
			if(strtotime($_POST['busqueda_final_prestamo']) < strtotime($_POST['busqueda_inicio_prestamo'])){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La fecha final no puede ser menor que la fecha inicial",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$_SESSION['busqueda_inicio_prestamo']=$_POST['busqueda_inicio_prestamo'];
			$_SESSION['busqueda_final_prestamo']=$_POST['busqueda_final_prestamo'];
			$url="reservation-search";
		}

		if(isset($_POST['eliminar_busqueda_prestamo'])){
			unset($_SESSION['busqueda_inicio_prestamo']);
			unset($_SESSION['busqueda_final_prestamo']);
			$url="reservation-search";
		}


		/*----------  Redireccionamiento general  ----------*/
		$alerta=[
			"Alerta"=>"redireccionar",
			"URL"=>SERVERURL.$url."/"
		];
		echo json_encode($alerta);
	}else{
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
	}