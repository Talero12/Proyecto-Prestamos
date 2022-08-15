<?php

    if($peticionAjax){
        require_once "../modelos/clienteModelo.php";
    }else{
        require_once "./modelos/clienteModelo.php";
    }

    class clienteControlador extends clienteModelo{
        
        /*----------  Controlador agregar cliente  ----------*/
        public function agregar_cliente_controlador(){

            $dni=mainModel::limpiar_cadena($_POST['cliente_dni_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

            /*== Comprobando que los campos no estén vacios ==*/
            if($dni=="" || $nombre=="" || $apellido=="" || $telefono=="" || $direccion==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son requeridos.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }


            /*== Verificar la integridad de los datos ==*/
            if(mainModel::verificar_datos("[0-9-]{1,27}",$dni)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El DNI no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$nombre)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$apellido)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El apellido que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El teléfono que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}",$direccion)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La dirección que ha ingresado no coincide con el formato solicitado. Solo se permiten los siguientes símbolos () . , # -",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
			 	exit();
            }

            /*== Comprobando DNI ==*/
            $check_dni=mainModel::ejecutar_consulta_simple("SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'");
            if($check_dni->rowCount()>0){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            $datos_cliente_reg=[
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];

            $agregar_cliente=clienteModelo::agregar_cliente_modelo($datos_cliente_reg);
            
            if($agregar_cliente->rowCount()==1){
                $alerta=[
					"Alerta"=>"limpiar",
					"Titulo"=>"¡Usuario registrado!",
					"Texto"=>"Los datos del cliente han sido registrados en el sistema.",
					"Tipo"=>"success"
				];
            }else{
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el cliente, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
            }
            echo json_encode($alerta);  
        } /*-- Fin controlador --*/


        /*----------  Controlador paginador cliente  ----------*/
		public function paginador_cliente_controlador($pagina,$registros,$privilegio,$url,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);

			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE cliente_dni LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%' ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);

			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas =ceil($total/$registros);

			### Cuerpo de la tabla ###
			$tabla.='
				<div class="table-responsive">
				<table class="table table-dark table-sm">
					<thead>
						<tr class="text-center roboto-medium">
							<th>#</th>
							<th>DNI</th>
							<th>NOMBRE</th>
							<th>APELLIDO</th>
							<th>TELEFONO</th>
							<th>DIRECCIÓN</th>';
							if($privilegio==1 || $privilegio==2){
								$tabla.='<th>ACTUALIZAR</th>';
							}
							if($privilegio==1){
								$tabla.='<th>ELIMINAR</th>';
							}
						$tabla.='</tr>
					</thead>
					<tbody>
			';

			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				$reg_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="text-center" >
							<td>'.$contador.'</td>
							<td>'.$rows['cliente_dni'].'</td>
							<td>'.$rows['cliente_nombre'].'</td>
							<td>'.$rows['cliente_apellido'].'</td>
							<td>'.$rows['cliente_telefono'].'</td>
							<td>
								<button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'" data-content="'.$rows['cliente_direccion'].'">
									<i class="fas fa-info-circle"></i>
								</button>
							</td>';
							if($privilegio==1 || $privilegio==2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'client-update/'.mainModel::encryption($rows['cliente_id']).'/" class="btn btn-success">
												<i class="fas fa-sync-alt"></i>	
										</a>
									</td>
								';
							}
							if($privilegio==1){
								$tabla.='
									<td>
										<form class="FormularioAjax" action="'.SERVERURL.'ajax/clienteAjax.php" method="POST" data-form="delete" enctype="multipart/form-data" autocomplete="off" >
											<input type="hidden" name="cliente_id_del" value="'.mainModel::encryption($rows['cliente_id']).'">
											<button type="submit" class="btn btn-warning">
													<i class="far fa-trash-alt"></i>
											</button>
										</form>
									</td>
								';
							}
						$tabla.='</tr>
					';
					$contador++;
				}
				$reg_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr class="text-center" >
							<td colspan="8">
								No hay registros en el sistema
							</td>
						</tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			### Paginacion ###
			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<p class="text-right">Mostrando Usuario '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
				$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,7);
			}

			return $tabla;
		} /*-- Fin controlador --*/


        /*----------  Controlador datos cliente  ----------*/
		public function datos_cliente_controlador($tipo,$id){
			$tipo=mainModel::limpiar_cadena($tipo);

			$id=mainModel::decryption($id);
			$id=mainModel::limpiar_cadena($id);

			return clienteModelo::datos_cliente_modelo($tipo,$id);
		} /*-- Fin controlador --*/


		/*----------  Controlador actualizar cliente  ----------*/
        public function actualizar_cliente_controlador(){

        	/*== Recuperando id ==*/
        	$id=mainModel::decryption($_POST['cliente_id_up']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando cliente en la DB ==*/
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");
            if($check_cliente->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el cliente en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }else{
            	$campos=$check_cliente->fetch();
            }

            $dni=mainModel::limpiar_cadena($_POST['cliente_dni_up']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_up']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_up']);

            /*== Comprobando que los campos no estén vacios ==*/
            if($dni=="" || $nombre=="" || $apellido=="" || $telefono=="" || $direccion==""){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No has llenado todos los campos que son requeridos.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Verificar la integridad de los datos ==*/
            if(mainModel::verificar_datos("[0-9-]{1,27}",$dni)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El DNI no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$nombre)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}",$apellido)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El apellido que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}",$telefono)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El teléfono que ha ingresado no coincide con el formato solicitado.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}",$direccion)){
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La dirección que ha ingresado no coincide con el formato solicitado. Solo se permiten los siguientes símbolos () . , # -",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
			 	exit();
            }

            /*== Comprobando DNI ==*/
            if($dni!=$campos['cliente_dni']){
	            $check_dni=mainModel::ejecutar_consulta_simple("SELECT cliente_dni FROM cliente WHERE cliente_dni='$dni'");
	            if($check_dni->rowCount()>0){
	                $alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"El DNI ingresado ya se encuentra registrado en el sistema.",
						"Tipo"=>"error"
					];
					echo json_encode($alerta);
					exit();
	            }
            }

            /*== Comprobando privilegios ==*/
			session_start(['name'=>'SPM']);
			if($_SESSION['privilegio_spm']<1 || $_SESSION['privilegio_spm']>2){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

            $datos_cliente_up=[
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "ID"=>$id
            ];

            
            if(clienteModelo::actualizar_cliente_modelo($datos_cliente_up)){
                $alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Usuario actualizado!",
					"Texto"=>"Los datos del cliente han sido actualizados en el sistema.",
					"Tipo"=>"success"
				];
            }else{
                $alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del cliente, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador --*/


        /*----------  Controlador eliminar cliente  ----------*/
        public function eliminar_cliente_controlador(){

        	/*== Recuperando id ==*/
        	$id=mainModel::decryption($_POST['cliente_id_del']);
			$id=mainModel::limpiar_cadena($id);

			/*== Comprobando cliente en la DB ==*/
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM cliente WHERE cliente_id='$id'");
            if($check_cliente->rowCount()<=0){
            	$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos encontrado el cliente en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
            }

            /*== Comprobando prestamos ==*/
			$check_prestamos=mainModel::ejecutar_consulta_simple("SELECT cliente_id FROM prestamo WHERE cliente_id='$id'");
			if($check_prestamos->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar el cliente debido a que tiene prestamos asociados.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*== Comprobando privilegios ==*/
			session_start(['name'=>'SPM']);
			if($_SESSION['privilegio_spm']!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta operación en el sistema.",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			$eliminar_cliente=clienteModelo::eliminar_cliente_modelo($id);

			if($eliminar_cliente->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"¡Usuario eliminado!",
					"Texto"=>"El cliente ha sido eliminado del sistema exitosamente.",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el cliente del sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
        } /*-- Fin controlador --*/
    }