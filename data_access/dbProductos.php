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
        case 'nombre':
            $orden = 'Nombre';
            break;
        default:
            $orden = 'Fecha DESC';
            break;
    }

    $posicion = ($pagina - 1) * $limite;

    switch ($filtro) {
        case 'productos-destacados':
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria 
                        FROM productos AS P 
                        INNER JOIN marcas AS M ON P.Marca = M.idMarca 
                        INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
                        WHERE Destacado=1 
                        ORDER BY $orden LIMIT $posicion, $limite";
            break;
        case 'todos-los-productos';
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria 
                        FROM productos AS P 
                        INNER JOIN marcas AS M ON P.Marca = M.idMarca 
                        INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
                        ORDER BY $orden LIMIT $posicion, $limite";
            break;
        default:
            $consulta = "SELECT P.idProducto, P.Nombre, P.Precio, P.Presentacion, P.Stock, P.Imagen, M.Nombre AS Marca, C.Nombre AS Categoria 
                        FROM productos AS P INNER 
                        JOIN marcas AS M ON P.Marca = M.idMarca 
                        INNER JOIN categorias AS C ON P.Categoria = C.idCategoria 
                        WHERE P.Nombre LIKE '%$filtro%' OR M.Nombre LIKE '%$filtro%' OR C.Nombre LIKE '%$filtro%' OR P.Presentacion LIKE '%$filtro%' 
                        ORDER BY $orden LIMIT $posicion, $limite";
            break;
    }

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
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

    if (mysqli_num_rows($resultado)>0) {
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

    $consulta = "SELECT p.idProducto, p.Nombre, p.Precio, p.Presentacion, p.Descripcion, p.Stock, p.Imagen, p.Marca, M.Nombre AS NombreMarca, p.Categoria, C.Nombre AS NombreCategoria 
                FROM productos AS p
                INNER JOIN marcas AS M ON p.Marca = M.idMarca 
                INNER JOIN categorias AS C ON p.Categoria = C.idCategoria 
                WHERE idProducto=$id";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
        return mysqli_fetch_assoc($resultado);
    }else {
        return [];
    }    
}

/*****************************************************************************
 *                      SELECCIONA TODAS LAS MARCAS
 *****************************************************************************/
function selectMarcas()
{
    global $conexion;

    $consulta = "SELECT * FROM marcas";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        return [];
    }  
}

/*****************************************************************************
 *                      SELECCIONA TODAS LAS CATEGORIAS
 *****************************************************************************/
function selectCategorias()
{
    global $conexion;

    $consulta = "SELECT * FROM categorias";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

/*****************************************************************************
 *                      AGREGA UN NUEVO PRODUCTO
 *****************************************************************************/
function InsertProducto($nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagen){
    global $conexion;
        
    $consulta = "INSERT INTO productos (Nombre, Precio, Marca, Categoria, Presentacion, Stock, Imagen) 
                    VALUES ('$nombre', $precio, $marca, $categoria, '$presentacion', $stock, '$imagen')";

    mysqli_query($conexion, $consulta);

    return mysqli_affected_rows($conexion);    
}

/*****************************************************************************
 *                      ACTUALIZA UN PRODUCTO POR EL ID
 *****************************************************************************/
function UpdateProducto($id, $nombre, $precio, $marca, $categoria, $presentacion, $stock,  $imagen){
    global $conexion;

    $consulta ="UPDATE productos 
                SET Nombre = '$nombre', Precio = $precio, Marca = $marca, Categoria = $categoria, Presentacion = '$presentacion', Stock = $stock, Imagen = '$imagen' 
                WHERE idProducto = $id";
                
    mysqli_query($conexion, $consulta);

    return mysqli_affected_rows($conexion);
}

/*****************************************************************************
 *                      ELIMINA UN PRODUCTO POR EL ID
 *****************************************************************************/
function DeleteProducto($id){
    global $conexion;
    
    $consulta ="DELETE FROM productos WHERE idProducto = $id";
    
    mysqli_query($conexion, $consulta);

    return mysqli_affected_rows($conexion);
}