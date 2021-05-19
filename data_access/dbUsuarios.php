<?php

/*****************************************************************************
 *                      ************ NOTAS ***********
 *****************************************************************************/
/* Cuando se realizan conversiones a boolean, los siguientes valores se consideran FALSE:
el boolean FALSE mismo
el integer 0 y -0 (cero)
el float 0.0 y -0.0 (cero)
el valor string vacío, y el string "0"
un array con cero elementos
el tipo especial NULL (incluidas variables no establecidas)
objetos SimpleXML creados desde etiquetas vacías

Cualquier otro valor se considera como TRUE (incluido cualquier resource y NAN). */


/*****************************************************************************
 *                VERIFICA EL EMAIL Y CONTRASEÑA DEL USUARIO
 *****************************************************************************/
function loginUsuario($email, $pass)
{
    global $conexion;

    // $consulta = "SELECT * FROM usuarios
    //                 WHERE Email = '$email' AND Pass = '$pass' ";

    // $resultado = mysqli_query($conexion, $consulta);

    // if ($resultado) {
    //     return mysqli_fetch_assoc($resultado);
    // }else {
    //     return false;
    // }

    $consultaClienteUsuario = "SELECT L.idUsuario, Nombre, Apellido, Email, 0 AS Rol 
                    From login AS L
                    INNER JOIN clientes_usuario AS U ON L.idClienteUsuario = U.id
                    WHERE Email = '$email' AND Pass = '$pass' AND Estado = 1";

    $consultaClienteEmpresa = "SELECT L.idUsuario, RazonSocial, Email, 1 AS Rol 
                    From login AS L
                    INNER JOIN clientes_empresa AS E ON L.idClienteEmpresa = E.id
                    WHERE Email = '$email' AND Pass = '$pass' AND Estado = 1";

    $resultadoClienteUsuario = mysqli_query($conexion, $consultaClienteUsuario);

    $resultadoClienteEmpresa = mysqli_query($conexion, $consultaClienteEmpresa);

    if (mysqli_num_rows($resultadoClienteUsuario) > 0) {

        return mysqli_fetch_assoc($resultadoClienteUsuario);

    } else if (mysqli_num_rows($resultadoClienteEmpresa) > 0) {

        return mysqli_fetch_assoc($resultadoClienteEmpresa);

    } else{

        return false;

    }

}

/*****************************************************************************
 *               SELECCIONO DATOS COMPLETOS DE USUARIO POR ID
 *****************************************************************************/
function SelectUsuario($id)
{
    global $conexion;

    /*$consulta = "SELECT L.Rol, U.Nombre, U.Apellido, E.RazonSocial, L.Email, L.Pass, 
                    CASE WHEN L.Rol = 0 
                        THEN U.id
                        ELSE E.id
                    END AS IdCliente,
                    CASE WHEN L.Rol = 0 
                        THEN U.direccion
                        ELSE E.direccion
                    END AS Direccion,
                    CASE WHEN L.Rol = 0 
                        THEN U.telefono
                        ELSE E.telefono
                    END AS Telefono
                FROM login AS L
                LEFT JOIN clientes_usuario AS U ON L.idClienteUsuario = U.id
                LEFT JOIN clientes_empresa AS E ON L.idClienteEmpresa = E.id
                WHERE L.idUsuario = $id";*/

    $consulta = "SELECT L.Rol, U.Nombre, U.Apellido, E.RazonSocial, L.Email, L.Pass, 
                    IFNULL (U.id, E.id) AS IdCliente, 
                    IFNULL(U.direccion, E.direccion) AS Direccion, 
                    IFNULL(U.telefono, E.telefono) AS Telefono 
                FROM login AS L 
                LEFT JOIN clientes_usuario AS U ON L.idClienteUsuario = U.id 
                LEFT JOIN clientes_empresa AS E ON L.idClienteEmpresa = E.id 
                WHERE L.idUsuario = $id";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
        return mysqli_fetch_assoc($resultado);
    }else {
        return [];
    }
}


/*****************************************************************************
 *                INSERTAR USUARIO EN LA TABLA SEGUN EL ROL
 *****************************************************************************/
function insertUsuario($rol, $usuario){
    
    global $conexion;

    if ($rol == 1) {
        $razonSocial = trim($usuario['RazonSocial']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim(strtolower($usuario['Email']));
        $pass = trim($usuario['Pass']);
        
        $consulta = "INSERT INTO clientes_empresa ( RazonSocial, Direccion, Telefono )
        VALUES ( '$razonSocial', '$direccion', '$telefono' );";

        mysqli_query($conexion, $consulta);

        $ultimo_id = mysqli_insert_id($conexion);

        $consulta = "INSERT INTO login (Rol, idClienteEmpresa, Email, Pass, Estado )
            VALUES ( $rol, $ultimo_id, '$email', '$pass', 1 );";

        mysqli_query($conexion, $consulta);

    } else if ($rol == 0) {
        $nombre = trim($usuario['Nombre']);
        $apellido = trim($usuario['Apellido']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim(strtolower($usuario['Email']));
        $pass = trim($usuario['Pass']);

        $consulta = "INSERT INTO clientes_usuario ( Nombre, Apellido, Direccion, Telefono )
        VALUES ( '$nombre', '$apellido', '$direccion', '$telefono' );";

        mysqli_query($conexion, $consulta);

        $ultimo_id = mysqli_insert_id($conexion);

        $consulta = "INSERT INTO login (Rol, idClienteUsuario, Email, Pass, Estado )
            VALUES ( $rol, $ultimo_id, '$email', '$pass', 1 );";

        mysqli_query($conexion, $consulta);
    }
    
    return mysqli_affected_rows($conexion);
}

/*****************************************************************************
 *                ACTUALIZO EL USUARIO EN LA TABLA SEGUN EL ID
 *****************************************************************************/
function UpdateUsuario($usuario){
    
    global $conexion;

    $id = $usuario['Id'];
    $rol = $usuario['Rol'];
    $idCliente = $usuario['IdCliente'];
    $nombre = trim($usuario['Nombre']);
    $apellido = trim($usuario['Apellido']);
    $razonSocial = trim($usuario['RazonSocial']);
    $direccion = trim($usuario['Direccion']);
    $telefono = trim($usuario['Telefono']);
    $email = trim(strtolower($usuario['Email']));
    $pass = trim($usuario['Pass']);

    $consulta1 = "UPDATE login
                SET Email = '$email', Pass = '$pass' 
                WHERE IdUsuario = $id";

    if ($rol == 1){
        $consulta2 = "UPDATE clientes_empresa
                    SET  RazonSocial = '$razonSocial', Direccion = '$direccion', Telefono = '$telefono' 
                    WHERE id = $idCliente";
    } else if ($rol == 0) {
        $consulta2 = "UPDATE clientes_usuario 
                    SET Nombre = '$nombre', Apellido = '$apellido', Direccion = '$direccion', Telefono = '$telefono' 
                    WHERE id = $idCliente";
    }
            
    mysqli_query($conexion, $consulta1);

    $affectedRows = mysqli_affected_rows($conexion);

    mysqli_query($conexion, $consulta2);

    $affectedRows += mysqli_affected_rows($conexion);
    
    return $affectedRows;
}

/*****************************************************************************
 *                ELIMINO EL USUARIO EN LA TABLA SEGUN EL ID
 *****************************************************************************/
function DeleteUsuario($usuario){
    
    global $conexion;

    $id = $usuario['Id'];
    $rol = $usuario['Rol'];
    $idCliente = $usuario['IdCliente'];
    
    $consulta1 = "DELETE FROM login
                WHERE IdUsuario = $id";

    if ($rol == 1){
        $consulta2 = "DELETE FROM clientes_empresa
                    WHERE id = $idCliente";
    } else if ($rol == 0) {
        $consulta2 = "DELETE FROM clientes_usuario 
                    WHERE id = $idCliente";
    }
    
    mysqli_query($conexion, $consulta1);

    $affectedRows = mysqli_affected_rows($conexion);

    mysqli_query($conexion, $consulta2);

    $affectedRows += mysqli_affected_rows($conexion);
    
    return $affectedRows;
}


/*****************************************************************************
 *                        VERIFICA SI EXISTE EL MAIL
 *****************************************************************************/
function existMailUsuario($email) {
    
    global $conexion;

    $email = trim(strtolower($email));

    $consulta = "SELECT Email FROM login
                    WHERE Email = '$email'";

    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado)>0) {
        return true;
    }else {
        return false;
    }
}
?>