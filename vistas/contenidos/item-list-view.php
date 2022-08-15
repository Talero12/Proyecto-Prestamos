<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS
    </h3>
    <p class="text-justify">
        
        Bienvenido, En la tabla muestra información de items en el inventario

    </p>
</div>
<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>item-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>item-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/itemControlador.php";
        $ins_item = new itemControlador();

        $pagina=explode("/", $_GET['views']);

        echo $ins_item->paginador_item_controlador($pagina[1],15,$_SESSION['privilegio_spm'],$pagina[0],"");
    ?>
</div>