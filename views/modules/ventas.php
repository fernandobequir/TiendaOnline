<?php

if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

$usuario = $_SESSION["Usuario"];
    $idUsuario = $usuario["Id"];

    // Valido que haya una accion por GET
    if( isset( $_GET["action"] ) ){
        $action = $_GET["action"];
        $idVenta = $_GET["idVenta"];

        switch ($action) {
            case 'porentregar':
                UpdateVentaEstado($idVenta, 'por entregar');
                header('location: ?menu=panel&modulo=ventas');
                break;
            
            case 'entregado':
                UpdateVentaEstado($idVenta, 'entregado');
                header('location: ?menu=panel&modulo=ventas');
                break;
        }
    }


    $productosVentas = SelectVentasAll();
    if (!empty($productosVentas)) {
?>

<h2 style="margin:20px;">Ventas</h2>


<?php // Todo: HACER RESPONSIVE********* ?>
<table class="responsive-ventas">
    <thead>
    <tr>
        <th>N°</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Cambiar Estado</th>
    </tr>
    </thead>
    <tbody>

<?php

        $sinStock = false;
        $isValidBuy = true;

        foreach ($productosVentas as $producto) {
            $idVenta = $producto["id"];
            $fecha = $producto["fecha"];
            $cliente = $producto["cliente"];
            $idProducto = $producto["idProducto"];
            $nombre = $producto["nombre"];            
            $cantidad = $producto["cantidad"];
            $precio = $producto["precio"];
            $total = $producto["total"];
            $estado = $producto["estado"];
            $stock = $producto["stock"];

            if ($cantidad > $stock) {
                $sinStock = true;
                $isValidBuy = false;
            } else {
                $sinStock = false;
            }
            
?>

        <tr>
            <td><?= $idVenta ?></td>
            <td><?= $fecha ?></td>
            <td><?= $cliente ?></td>
            <td><?= $nombre ?></td>
            <td><?= $cantidad ?></td>
            <td>$ <?= $precio ?></td>
            <td>$ <?= $total ?></td>

            <?php
            if ($estado == "por entregar") {
                echo "<td style='color:slateblue;'><strong> $estado </strong></td>";
            } else {
                echo "<td style='color:limegreen;'><strong> $estado </strong></td>";
            }
            ?>
            
            <td>
                <a href="?menu=panel&modulo=ventas&action=porentregar&idVenta=<?= $idVenta ?>" title="Por entregar"><i class="fas fa-hourglass-half fa-md" style="color:slateblue; padding:5px; text-align:center;"></i></a>
                <a href="?menu=panel&modulo=ventas&action=entregado&idVenta=<?= $idVenta ?>" title="Entregado"><i class="fas fa-check fa-lg" style="color:limegreen; padding:5px; text-align:center;"></i></a>
            </td>

        </tr>


<?php   } ?>

    </tbody>
</table>


<?php } else { ?>

    <div>
    <h3 style="margin: 20px">Aún no se realizó ninguna venta</h3>    </div>

<?php
    }
?>

