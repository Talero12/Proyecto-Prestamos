<?php

    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }

    class empresaControlador extends empresaModelo{


        /*----------  Controlador agregar empresa ----------*/
        public function agregar_empresa_controlador(){

            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);

            /*== Comprobando que los campos no estén vacios ==*/
            if($nombre=="" || $email=="" || $telefono=="" || $direccion==""){
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
            if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El nombre no coincide con el formato solicitado.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Ha ingresado un correo electrónico no válido.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El teléfono no coincide con el formato solicitado.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"La dirección no coincide con el formato solicitado. Solo se permiten los siguientes símbolos () . , # -",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            
            /*== Comprobando empresas registradas ==*/
            $check_empresa=mainModel::ejecutar_consulta_simple("SELECT empresa_id FROM empresa");
            if($check_empresa->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Ya existe una empresa registrada, ya no puedes registrar mas.",
                    "Tipo"=>"error"
                ];
                exit();
            }


            $datos_empresa_reg=[
                "Nombre"=>$nombre,
                "Email"=>$email,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];


            $agregar_empresa=empresaModelo::agregar_empresa_modelo($datos_empresa_reg);

            if($agregar_empresa->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Empresa registrada!",
                    "Texto"=>"Los datos de la empresa se registraron con éxito.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido registrar los datos en el sistema, por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador --*/


        /*----------  Controlador seleccionar datos empresa  ----------*/
        public function datos_empresa_controlador(){
            return empresaModelo::datos_empresa_modelo();
        } /*-- Fin controlador --*/


        /*----------  Controlador actualizar empresa  ----------*/
        public function actualizar_empresa_controlador(){

            $id=mainModel::limpiar_cadena($_POST['empresa_id_up']);
            $nombre=mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
            $email=mainModel::limpiar_cadena($_POST['empresa_email_up']);
            $telefono=mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
            $direccion=mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

            if($nombre=="" || $email=="" || $telefono=="" || $direccion==""){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No has llenado todos los campos que son requeridos.",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

             /*== Verificar la integridad de los datos ==*/
             if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $nombre)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre no coincide con el formato solicitado.",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Ha ingresado un correo electrónico no válido.",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9()+]{8,20}", $telefono)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El teléfono no coincide con el formato solicitado.",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La dirección no coincide con el formato solicitado. Solo se permiten los siguientes símbolos () . , # -",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
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


            $datos_empresa_up=[
                "ID"=>$id,
                "Nombre"=>$nombre,
                "Email"=>$email,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion
            ];

           
            if(empresaModelo::actualizar_empresa_modelo($datos_empresa_up)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡Empresa actualizada!",
                    "Texto"=>"Los datos de la empresa han sido actualizados con éxito.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"No hemos podido actualizar los datos de la empresa, por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        } /*-- Fin controlador --*/
    }