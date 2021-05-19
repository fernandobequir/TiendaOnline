<?php

if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

?>

<h3 style="margin: 20px">Aún no se realizó ninguna venta</h3>