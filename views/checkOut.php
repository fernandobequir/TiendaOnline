<?php
// Compruebo si no se inicio sesión
if (!isset($_SESSION["Usuario"])) { 
    header('location: ./');
 } else { 

    // Si es administrador no va a comprar
    if ($_SESSION["Usuario"]["Administrador"] == 1) {
        header('location: ?menu=panel&modulo=ventas');
        die ();
    }

    $usuario = $_SESSION["Usuario"];
    $idCliente = $usuario["Id"];

    $productosCarrito = SelectCarrito($idCliente);
    if (!empty($productosCarrito)) {


        // Valido que se invoca uan peticion POST
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

            if(isset($_POST['pagar'])){

                // agregar compra a venta ...
                // si es ok
                // vaciar carrito...
                DeleteCarrito($idCliente);

                header('location: ?menu=checkOutRta');
            }
        }
    


?>
<h2 style="margin:20px; text-align:center;">Check Out</h2>
<form action="" method="POST">
<table class="responsive-carrito center">
    <thead>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
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
            <td><img style="max-width:50px" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>"></td>
        <?php else: ?>
            <td><img style="max-width:50px" src=""></td>
        <?php endif; ?>        
            <td><?= $nombre ?></td>
            <td><?= $cantidad ?></td>
            <td>$ <?= $precio ?></td>
            <td>$ <?= $precioParcial ?></td>
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
    <p>El total a pagar es <strong>$ <?= $precioTotal ?></strong></p>
</div>

<div class="center" style="width:60%">
Forma de pago 
<select name="formaPago" required >
    <option value="">Elija la forma de pago...</option>

        <option value="" > Mercado Pago </option>
        <option value="" > Tarjeta de crédito/débito </option>
        <option value="" > Pay Pal </option>

</select>
</div>



<div class="center" style="display:flex;">
    <input type="hidden" name="isValidBuy" value="<?= $isValidBuy ?>">
    <a href="?menu=carrito" class="button-link button-border" style="margin: 0px auto;">Atrás</a>
    <input type="submit" value="Pagar" name="pagar" style="margin: 0px auto;">
</div>
</form>
<?php 
    }
}
?>
