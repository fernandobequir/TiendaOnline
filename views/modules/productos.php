<?php

if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}


$filtro = 'todos-los-productos';

$orden = 'nombre';

if (isset($_GET['pag'])) {
    $pagina = $_GET['pag'];
} else {
    $pagina = 1;
}

$cantidad_productos = countProductos($filtro);

$limite = 4; // CANTIDAD DE PRODUCTOS POR PÁGINA

$paginas_total = ceil($cantidad_productos / $limite);


if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case '0x10':
            $msj = "Producto agregado!";
            $typeMsj = "msj-ok";
            break;
        case '0x11':
            $msj = "Producto agregado, pero hubo un error al tratar de guardar la imagen!";
            $typeMsj = "msj-warning";
            break;
        case '0x20':
            $msj = "Producto actualizado!";
            $typeMsj = "msj-ok";
            break;
        case '0x21':
            $msj = "Producto actualizado, pero hubo un error al tratar de guardar la imagen!";
            $typeMsj = "msj-warning";
            break;
        case '0x30':
            $msj = "Producto eliminado!";
            $typeMsj = "msj-warning";
            break;
        case '0x1000':
            $msj = "Hubo un error al intentar realizar la operación!";
            $typeMsj = "msj-error";
            break;       
    }
?>
    <!-- mensaje -->
    <div class="<?= $typeMsj ?> center-small"><?= $msj ?></div>
<?php
}
?>

<!-- enlace nuevo producto -->
<a href="?menu=panel&modulo=producto&action=add" class="button-link">Nuevo producto</a>
<!-- tabla productos -->
<br><br>
<table class="resp">
    <thead>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Marca</th>
        <th>Categoria</th>
        <th>Presentacion</th>
        <th>Stock</th>
        <th colspan="2">Acciones</th>
    </tr>
    </thead>
    <tbody>

    <?php
        $productos = selectProductos($filtro, $orden, $pagina, $limite);

        foreach ($productos as $producto) {
            $imagen = $producto['Imagen'];
            $id = $producto['idProducto'];
            $nombre = $producto['Nombre'];
            $precio = $producto['Precio'];
            $marca = $producto["Marca"];
            $categoria = $producto["Categoria"];
            $presentacion = $producto["Presentacion"];
            $stock = $producto["Stock"];        
    ?>

    <tr>
    <?php if( !empty($imagen) ) : ?>
        <td><img style="max-width:100px" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>"></td>
    <?php else: ?>
        <td><img style="max-width:100px" src=""></td>
    <?php endif; ?>        
        <td><?= $nombre ?></td>
        <td>$ <?= $precio ?></td>
        <td><?= $marca ?></td>
        <td><?= $categoria ?></td>
        <td><?= $presentacion ?></td>
        <td><?= $stock ?></td>
        <td>
            <a href="?menu=panel&modulo=producto&action=update&id=<?= $id ?>" title="Modificar"><i class="fas fa-edit fa-lg" style="color:cornflowerblue;"></i></a>
        </td>
        <td>
            <a href="?menu=panel&modulo=producto&action=delete&id=<?= $id ?>" title="Eliminar"><i class="fas fa-trash-alt fa-lg" style="color:crimson"></i></a>
        </td>
    </tr>

    <?php } ?>

    </tbody>
</table>

    <!-- paginador -->
    <?php if ($paginas_total > 1) { ?>
        <ul class="paginador">
                            
            <?php if ($pagina != 1) { ?>

                <li><a href="?menu=panel&modulo=productos&pag=<?= $pagina - 1 ?>">< Anterior</a></li>
            
            <?php } ?>

            <?php for ($i = 1; $i <= $paginas_total; $i++) { ?>
            
                <li><a class="<?= ($pagina == $i) ? 'active' : '' ; ?>" href="?menu=panel&modulo=productos&pag=<?= $i ?>"><?= $i ?></a></li>

            <?php } ?>

            <?php if ($pagina != $paginas_total) { ?>

                <li><a href="?menu=panel&modulo=productos&pag=<?= $pagina + 1 ?>">Siguiente ></a></li>

            <?php } ?>

        </ul>
    <?php } ?>
