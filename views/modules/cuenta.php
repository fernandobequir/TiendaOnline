<?php
// Valido que se haya iniciado sesión
if (!isset($_SESSION["Usuario"])){
    header('location: ./');
}

// recupero el rol
$id = $_SESSION["Usuario"]["Id"];

// Valido que tipo de peticion invoca al modulo
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    // Aca se deben procesar los datos del formulario ejecutado
    $usuario = array(
        "Id" => $_POST["id"],
        "Rol" => $_POST["rol"],
        "IdCliente" => $_POST["idCliente"],
        "Nombre" => $_POST["nombre"],
        "Apellido" => $_POST["apellido"],
        "RazonSocial" => $_POST["razonSocial"],
        "Direccion" => $_POST["direccion"],
        "Telefono" => $_POST["telefono"],
        "Email" => $_POST["email"],
        "Pass" => $_POST["pass"]
    );
    
    if(isset($_POST['update'])){      

        $msj = "0x1000";
        if (UpdateUsuario($usuario) > 0) {
            $msj = "0x20";
            // reinicio sesión
				session_start();
		
				$_SESSION["Usuario"] = array(
					"Id" => $usuario["Id"],
					"Nombre" => ($usuario["Nombre"]) ? $usuario["Nombre"] : $usuario["RazonSocial"] ,
					"Apellido" => $usuario["Apellido"],
					"Email" => $usuario["Email"],
					"Administrador" => $usuario['Rol']
				);
        }        

        header('location: ?menu=panel&modulo=cuenta&msj='. $msj);
    }
    if(isset($_POST['delete'])){

        $msj = "0x1000";
        if (DeleteUsuario($usuario) > 0) {
            //msj = "0x30";
            // cierro la sesión
            unset( $_SESSION );
            session_destroy();
            header('location: ./');
        }
        header('location: ?menu=panel&modulo=cuenta&msj='. $msj);
    }


} else {
    $usuario = SelectUsuario($id);

    $rol = $usuario["Rol"];
    $idCliente = $usuario["IdCliente"];
    $nombre = $usuario["Nombre"];
    $apellido = $usuario["Apellido"];
    $razonSocial = $usuario["RazonSocial"];
    $direccion = $usuario["Direccion"];
    $telefono = $usuario["Telefono"];
    $email = $usuario["Email"];
    $pass = $usuario["Pass"];
}

if (isset($_GET['msj'])) {
    $msj = $_GET['msj'];
    $typeMsj = "";
    switch ($msj) {
        case '0x20':
            $msj = "Cuenta actualizada!";
            $typeMsj = "msj-ok";
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




<h3 style="margin: 20px">Datos de la Cuenta</h3>
<div class="main">
	<form action="?menu=panel&modulo=cuenta" method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="rol" value="<?= $rol ?>">
        <input type="hidden" name="idCliente" value="<?= $idCliente ?>">
        <input type="hidden" name="email" value="<?= $email ?>">
        <?php if ($rol == 0) { ?>
            <div>
                <span>Nombre: </span>
                <input type="text" name="nombre" value="<?= $nombre ?>">
            </div>
            <div>
                <span>Apellido: </span>
                <input type="text" name="apellido" value="<?= $apellido ?>">
            </div>        
        <?php } ?>
        <?php if ($rol == 1) { ?>
            <div>
                <span>Razón Social: </span>
                <input type="text" name="razonSocial" value="<?= $razonSocial ?>">
            </div>
        <?php } ?>
        <div>
			<span>Dirección: </span>
			<input type="text" name="direccion" value="<?= $direccion ?>">
		</div>
        <div>
			<span>Teléfono: </span>
			<input type="text" name="telefono" value="<?= $telefono ?>">
		</div>
		<div>
			<span>Contraseña: </span>
			<input type="password" name="pass" value="<?= $pass ?>">
		</div>
			
            <input type="submit" value="Eliminar cuenta" name="delete" style="background-color:white; box-shadow: inset 0 0 0 1px crimson; color:crimson ;margin-right: 10px;">
            <input type="submit" value="Actualizar" name="update">
	</form>
	
</div>