<?php
// Compruebo si no se inicio sesión
if (!isset($_SESSION["Usuario"])) { ?>
    <div class="center-small" style="display:flex; flex-direction:column;">
    <h3 style="margin: 20px; text-align:center;">Debes iniciar sesión para poder ver el carrito!</h3>
    <a style="margin: 20px auto;" class="button-link" href="./?menu=ingreso">Iniciar sesión</a>
</div>
<?php } else { ?>

<?php
    // Si es administrador no va a comprar
    if ($_SESSION["Usuario"]["Administrador"] == 1) {
        header('location: ?menu=panel&modulo=ventas');
        die ();
    }

    $usuario = $_SESSION["Usuario"];
    $idCliente = $usuario["Id"];


    // Valido que se invoca uan peticion POST
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

        if(isset($_POST['clearCart'])){
            DeleteCarrito($idCliente);
            echo ("<h2 class='msj-warning'>Carrito vacío</h2>");
        }
        if(isset($_POST['comprar'])){
            if ($_POST["isValidBuy"]) {
                header('location: ?menu=checkOut');
            } else {
                echo ("<h2 class='msj-error'>No se puede comprar porque no hay stock</h2>");

            }
        }
    }
    // Valido que haya una accion por GET
    if( isset( $_GET["action"] ) ){
        $action = $_GET["action"];
        $idProducto = $_GET["idProduct"];

        DeleteCarritoProduct($idCliente, $idProducto);
        //echo ("<h2 class='msj-warning'>Producto quitado</h2>");
        header('location: ?menu=carrito');
    }


    $productosCarrito = SelectCarrito($idCliente);
    if (!empty($productosCarrito)) {
?>
<h2 style="margin:20px; text-align:center;">Carrito</h2>
<form action="" method="POST">
<table class="responsive-carrito center">
    <thead>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Quitar</th>
    </tr>
    </thead>
    <tbody>

<?php

        $precioTotal = 0.0;
        $sinStock = false;
        $isValidBuy = true;

        foreach ($productosCarrito as $producto) {
            $idCarrito = $producto["id"];
            $idProducto = $producto["idProducto"];
            $imagen = $producto["Imagen"];
            $nombre = $producto["Nombre"];            
            $cantidad = $producto["cantidad"];
            $precio = $producto["Precio"];
            $precioParcial = $producto["PrecioParcial"];
            $stock = $producto["Stock"];
            $precioTotal += $precioParcial;

            if ($cantidad > $stock) {
                $sinStock = true;
                $isValidBuy = false;
            } else {
                $sinStock = false;
            }
            
?>

        <tr>
        <?php if( !empty($imagen) ) : ?>
            <td><img style="max-width:100px" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>"></td>
        <?php else: ?>
            <td><img style="max-width:100px" src=""></td>
        <?php endif; ?>        
            <td><?= $nombre ?></td>
            <td><?= $cantidad ?></td>
            <td>$ <?= $precio ?></td>
            <td>$ <?= $precioParcial ?></td>
            <td>
            <a href="?menu=carrito&action=quitar&idProduct=<?= $idProducto ?>" title="Eliminar"><i class="fas fa-trash-alt fa-lg" style="color:crimson"></i></a>
            </td>
            <?php 
            
            if( $sinStock ) : 
            ?>
            <td style="color:crimson; border: 1px solid #ededed; padding:20px; text-align:center;"><b >Sin Stock!<b></td>
            <?php 
            endif; ?>    
        </tr>


<?php   } ?>

    </tbody>
</table>

<div class="center" style="text-align: center; font-size:1.2em;">
    <p>El total del carrito es de <strong>$ <?= $precioTotal ?></strong></p>
</div>

<div class="center" style="display:flex;">
    <input type="hidden" name="isValidBuy" value="<?= $isValidBuy ?>">
    <input type="submit" value="Vaciar carrito" name="clearCart" style="margin: 0px auto; background-color:white; box-shadow: inset 0 0 0 1px crimson; color:crimson;">
    <input type="submit" value="Comprar" name="comprar" style="margin: 0px auto;">
</div>
</form>
<?php } else { ?>

<div class="center-small" style="display:flex; flex-direction:column;">
    <h3 style="margin: 20px; text-align:center;">Tu carito está vacío</h3>
    <a style="margin: 20px auto;" class="button-link" href="./">Busquemos algo</a>
</div>

<?php
    }
}
?>