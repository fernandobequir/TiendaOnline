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
        <?php // Si es administrador se da acceso a los modulos de administrador ?>
        <?php if ($_SESSION["Usuario"]["Administrador"]) { ?>
            <a href="?menu=panel&modulo=ventas" class="<?= ($_GET['modulo'] == 'ventas') ? 'nav-active' : '' ; ?>"><i class="fas fa-store"></i><span>Ventas</span></a>
            <a href="?menu=panel&modulo=productos" class="<?= ($_GET['modulo'] == 'productos') ? 'nav-active' : '' ; ?>"><i class="fas fa-box"></i><span>Productos</span></a>
        <?php } else { ?>
        <?php // Acceso a compras solo si no es administrador ?>
            <a href="?menu=panel&modulo=compras" class="<?= ($_GET['modulo'] == 'compras') ? 'nav-active' : '' ; ?>"><i class="fas fa-shopping-bag"></i><span>Compras</span></a>
        <?php } ?>
        <?php // Acceso al resto de los modulos para todos los tipos de usuario ?>
            <a href="?menu=panel&modulo=cuenta" class="<?= ($_GET['modulo'] == 'cuenta') ? 'nav-active' : '' ; ?>"><i class="fas fa-user-cog"></i><span>Cuenta</span></a>
            <span class="separador"></span>
            <a href="?menu=panel&sesion=cerrar"><i class="fas fa-sign-out-alt"></i><span>Cerrar sesión</span></a>
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

