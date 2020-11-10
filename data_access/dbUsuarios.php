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

    $consultaClienteUsuario = "SELECT Nombre, Apellido, Email, 0 AS Rol From login AS L
                    INNER JOIN clientes_usuario AS U ON L.idClienteUsuario = U.id
                    WHERE Email = '$email' AND Pass = '$pass' AND Estado = 1";

    $consultaClienteEmpresa = "SELECT RazonSocial, Email, 1 AS Rol From login AS L
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
 *                INSERTAR USUARIO EN LA TABLA SEGUN EL ROL
 *****************************************************************************/
function insertUsuario($rol, $usuario){
    
    global $conexion;

    if ($rol) {
        $razonSocial = trim($usuario['RazonSocial']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim($usuario['Email']);
        $pass = trim($usuario['Pass']);
        
        $consulta = "INSERT INTO clientes_empresa ( RazonSocial, Direccion, Telefono )
        VALUES ( '$razonSocial', '$direccion', '$telefono' );";

        mysqli_query($conexion, $consulta);

        $ultimo_id = mysqli_insert_id($conexion);

        $consulta = "INSERT INTO login ( idClienteEmpresa, Email, Pass, Estado )
            VALUES ( $ultimo_id, '$email', '$pass', 1 );";

        mysqli_query($conexion, $consulta);

    } else {
        $nombre = trim($usuario['Nombre']);
        $apellido = trim($usuario['Apellido']);
        $direccion = trim($usuario['Direccion']);
        $telefono = trim($usuario['Telefono']);
        $email = trim($usuario['Email']);
        $pass = trim($usuario['Pass']);

        $consulta = "INSERT INTO clientes_usuario ( Nombre, Apellido, Direccion, Telefono )
        VALUES ( '$nombre', '$apellido', '$direccion', '$telefono' );";

        mysqli_query($conexion, $consulta);

        $ultimo_id = mysqli_insert_id($conexion);

        $consulta = "INSERT INTO login ( idClienteUsuario, Email, Pass, Estado )
            VALUES ( $ultimo_id, '$email', '$pass', 1 );";

        mysqli_query($conexion, $consulta);
    }
    
    return mysqli_affected_rows($conexion);
}
/*****************************************************************************
 *                        VERIFICA SI EXISTE EL MAIL
 *****************************************************************************/
function existMailUsuario($email) {
    
    global $conexion;

    $email = trim($email);

    $consulta = "SELECT Email FROM login
                    WHERE Email = '$email'";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        return true;
    }else {
        return false;
    }
}
?>