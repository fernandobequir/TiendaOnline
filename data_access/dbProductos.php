<?php

/*****************************************************************************
 *                 SELECIONA LOS PRODUCTOS SEGUN CRITERIO
 *****************************************************************************/
function selectProductos($filtro, $orden, $pagina = 0, $limite = 10)
{

    global $conexion;

    switch ($orden) {
        case 'menor-precio':
            $orden = 'Precio';
            break;
        case 'mayor-precio':
            $orden = 'Precio DESC';
            break;
        default:
            $orden = 'Fecha';
            break;
    }

    $posicion = ($pagina - 1) * $limite;

    switch ($filtro) {
        case 'productos-destacados':
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
            WHERE Destacado=1 
            ORDER BY $orden LIMIT $posicion, $limite";
            break;
        case 'todos-los-productos';
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
            ORDER BY $orden LIMIT $posicion, $limite";
            break;
        default:
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
            WHERE P.Nombre LIKE '%$filtro%' OR M.Nombre LIKE '%$filtro%' OR C.Nombre LIKE '%$filtro%' OR P.Presentacion LIKE '%$filtro%' 
            ORDER BY $orden LIMIT $posicion, $limite";
            break;
    }

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $id = $fila['idProducto'];
            $nombre = $fila['Nombre'];
            $precio = $fila['Precio'];
            $imagen = $fila['Imagen'];
            // $marca = $fila['Marca'];
            // $categoria = $fila['Categoria'];
            // $presentacion = $fila['Presentacion'];
            // $stock = $fila['Stock'];            
?>

            <div class="item-grid-productos">
                <a href="?menu=producto&item=<?= $id ?>">
                    <img class="img-grid-productos" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>" />
                    <div class="detalle-grid-productos">
                        <span>$ <?= $precio ?></span>
                        <p><?= $nombre ?></p>
                    </div>
                </a>
            </div>

<?php
        }
    }
}


/*****************************************************************************
 *                     CANTIDAD DE PRODUCTOS POR FILTRO
 *****************************************************************************/
function countProductos($filtro)
{

    global $conexion;

    switch ($filtro) {
        case 'productos-destacados':
            $consulta = "SELECT COUNT(*) AS total FROM productos
                            WHERE Destacado=1";
            break;
        case 'todos-los-productos';
            $consulta = "SELECT COUNT(*) AS total FROM productos
                            ORDER BY Fecha";
            break;
        default:
            $consulta = "SELECT COUNT(*) AS total FROM productos AS P 
                            INNER JOIN marcas AS M ON P.Marca = M.idMarca 
                            INNER JOIN categorias AS C ON P.Categoria = C.idCategoria
                            WHERE P.Nombre LIKE '%$filtro%' OR M.Nombre LIKE '%$filtro%' OR C.Nombre LIKE '%$filtro%' OR P.Presentacion LIKE '%$filtro%'";
            break;
    }

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $total = mysqli_fetch_assoc($resultado);
        $cantidad_productos = $total['total'];
    }
    return $cantidad_productos;
}

/*****************************************************************************
 *                      SELECIONA UN PRODUCTO POR EL ID
 *****************************************************************************/
function selectProducto($id)
{

    global $conexion;

    $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Descripcion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
                    WHERE P.idProducto=$id";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        $producto = mysqli_fetch_assoc($resultado);
        $id = $producto['idProducto'];
        $nombre = $producto['Nombre'];
        $precio = $producto['Precio'];
        $marca = $producto['Marca'];
        $categoria = $producto['Categoria'];
        $presentacion = $producto['Presentacion'];
        $descripcion = $producto['Descripcion'];
        $stock = $producto['Stock'];
        $imagen = $producto['Imagen'];

?>

        <img class="detalle-imagen" src="img/productos/<?= $imagen ?>" />
        <div class="detalle-descripcion">
            <h4><?= $nombre ?></h4>
            <h2 class="precio">$ <?= $precio ?></h2>
            <h4 class="stock"><?= $stock ?> unid. en stock</h4>
            <p><?= "Categoría: $categoria | Marca: $marca | Presentación: $presentacion" ?></p>
            <p><?= $descripcion ?></p>
            <a class="button-comprar" href="#">COMPRAR</a>
        </div>


<?php

    }
}

?>