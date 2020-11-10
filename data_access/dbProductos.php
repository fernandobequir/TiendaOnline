<?php

/*****************************************************************************
 *                 SELECCIONA LOS PRODUCTOS SEGÚN CRITERIO
 *****************************************************************************/
function selectProductos($filtro, $orden, $pagina = 1, $limite = 10)
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
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        // while ($producto = mysqli_fetch_assoc($resultado)) {
        //     $productos[] = $producto;
        // }
        // return $productos;
    } else {
        return [];
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
            $consulta = "SELECT COUNT(*) AS total FROM productos";
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
        return $total['total'];
    } else {
        return 0;
    }    
}

/*****************************************************************************
 *                      SELECCIONA UN PRODUCTO POR EL ID
 *****************************************************************************/
function selectProducto($id)
{
    global $conexion;

    $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Descripcion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria FROM productos AS P INNER JOIN marcas AS M ON P.Marca = M.idMarca INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
                    WHERE P.idProducto=$id";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    }else {
        return false;
    }    
}