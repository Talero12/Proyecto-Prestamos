<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-building fa-fw"></i> &nbsp; INFORMACÓN DE LA EMPRESA
    </h3>
    <p class="text-justify">
       
        DISCOVERY COMMUNICATIONS COLOMBIA LTDA, 

    </p>
</div>
<?php
    require_once "./controladores/empresaControlador.php";
    $ins_empresa = new empresaControlador();

    $datos_empresa=$ins_empresa->datos_empresa_controlador("Conteo",0);

    if($datos_empresa->rowCount()==0){
?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="save" enctype="multipart/form-data" autocomplete="off">
        <fieldset>
            <legend><i class="far fa-building"></i> &nbsp; Información de la empresa</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_nombre" class="bmd-label-floating">Nombre de la empresa</label>
                            <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="empresa_nombre_reg" id="empresa_nombre" maxlength="70" required="" >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_email" class="bmd-label-floating">Correo</label>
                            <input type="email" class="form-control" name="empresa_email_reg" id="empresa_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_telefono" class="bmd-label-floating">Telefono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_reg" id="empresa_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="empresa_direccion_reg" id="empresa_direccion" maxlength="190" required="" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>
<?php 
    }elseif($datos_empresa->rowCount()==1 && ($_SESSION['privilegio_spm']==1 || $_SESSION['privilegio_spm']==2)){
        $campos=$datos_empresa->fetch();
?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="update" enctype="multipart/form-data" autocomplete="off" >
        <input type="hidden" name="empresa_id_up" value="<?php echo $campos['empresa_id']; ?>">
        <fieldset>
            <legend><i class="far fa-building"></i> &nbsp;Actualizar Información de la empresa</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_nombre" class="bmd-label-floating">Nombre de la empresa</label>
                            <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}" class="form-control" name="empresa_nombre_up" value="<?php echo $campos['empresa_nombre']; ?>" id="empresa_nombre" maxlength="70" required="" >
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_email" class="bmd-label-floating">Correo</label>
                            <input type="email" class="form-control" name="empresa_email_up" value="<?php echo $campos['empresa_email']; ?>" id="empresa_email" maxlength="70">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_telefono" class="bmd-label-floating">Telefono</label>
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_up" value="<?php echo $campos['empresa_telefono']; ?>" id="empresa_telefono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="empresa_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="empresa_direccion_up" value="<?php echo $campos['empresa_direccion']; ?>" id="empresa_direccion" maxlength="190" required="" >
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
</div>
<?php }else{ ?>
<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
    <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada o no tienes los permisos para ingresar a esta sección.</p>
</div>
<?php } ?>