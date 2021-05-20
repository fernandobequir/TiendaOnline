<?php
// Si es administrador no va a comprar
if ($_SESSION["Usuario"]["Administrador"] == 1) {
    header('location: ./');
}

$usuario = $_SESSION["Usuario"];
    $idUsuario = $usuario["Id"];

    $productosCompras = SelectVentas($idUsuario);
    if (!empty($productosCompras)) {
?>

<h2 style="margin:20px;">Compras</h2>

<?php // Todo: HACER RESPONSIVE********* ?>
<table class="responsive-compras">
    <thead>
    <tr>
        <th>N° Ref.</th>
        <th>Fecha</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>

<?php
        foreach ($productosCompras as $producto) {
            $idVenta = $producto["id"];
            $fecha = $producto["fecha"];
            $idProducto = $producto["idProducto"];
            $nombre = $producto["nombre"];            
            $cantidad = $producto["cantidad"];
            $precio = $producto["precio"];
            $total = $producto["total"];
            $estado = $producto["estado"];
            $stock = $producto["stock"];
            
?>

        <tr>
            <td><?= $idVenta ?></td>
            <td><?= $fecha ?></td>
            <td><?= $nombre ?></td>
            <td><?= $cantidad ?></td>
            <td>$ <?= $precio ?></td>
            <td>$ <?= $total ?></td>
            <?php
            if ($estado == "por entregar") {
                echo "<td style='color:slateblue; padding:5px; text-align:center;'><strong> $estado </strong></td>";
            } else {
                echo "<td style='color:limegreen; padding:5px; text-align:center;'><strong> $estado </strong></td>";
            }
            ?>        
        </tr>


<?php   } ?>

    </tbody>
</table>


<?php } else { ?>

    <div>
        <h3 style="margin: 20px">Todavia no has comprado</h3>
        <a style="margin: 20px" class="button-link" href="./">Vamos a comprar!</a>
    </div>

<?php
    }
?>


