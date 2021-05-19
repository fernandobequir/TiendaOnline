<?php
// Si es administrador no va a comprar
if ($_SESSION["Usuario"]["Administrador"] == 1) {
    header('location: ./');
}

?>


<h3 style="margin: 20px">Todavia no has comprado</h3>
<a style="margin: 20px" class="button-link" href="./">Vamos a comprar!</a>