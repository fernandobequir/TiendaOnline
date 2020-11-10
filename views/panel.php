<?php

// Chequeo si se abrió sesión
// session_start();
if (!isset($_SESSION["Usuario"])) {
    echo 'hahahahahahahahhahahaha';
    header('location: ./');
}

// chequeo si se está cerrando la sesión
if (isset($_GET['sesion']) && $_GET['sesion'] == 'cerrar') {
    unset( $_SESSION );
    session_destroy();
    header('location: ./');
}



?>
<section class="panel-users">
    <nav class="nav-panel">
            
        <?php if ($_SESSION["Usuario"]["Administrador"]) { ?>
            <a href="?menu=panel&modulo=ventas" class="<?= ($_GET['modulo'] == 'ventas') ? 'nav-active' : '' ; ?>">Ventas</a>
            <a href="?menu=panel&modulo=productos" class="<?= ($_GET['modulo'] == 'productos') ? 'nav-active' : '' ; ?>">Productos</a>
        <?php } ?>
            <a href="?menu=panel&modulo=compras" class="<?= ($_GET['modulo'] == 'compras') ? 'nav-active' : '' ; ?>">Compras</a>
            <a href="?menu=panel&modulo=cuenta" class="<?= ($_GET['modulo'] == 'cuenta') ? 'nav-active' : '' ; ?>">Cuenta</a>
            <span class="separador"></span>
            <a href="?menu=panel&sesion=cerrar">Cerrar sesión</a>
    </nav>

    <section class="container-panel">
        <?php
            // recibo el modulo al que se accedió
            if (isset($_GET['modulo'])) {

                $modulo = 'views/modules/' . $_GET['modulo'] . '.php';

                if (file_exists($modulo)) {
                    require_once ( $modulo );
                }
                else {
                    require_once ( "views/404.php" );
                }
            }
            
        ?>
    </section>
</section>

