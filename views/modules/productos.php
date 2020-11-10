<?php

if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

?>

<h1 style="text-align: center; margin: 20px">PRODUCTOS</h1>
<h2 style="text-align: center; margin: 20px">(funciones de admin)</h2>