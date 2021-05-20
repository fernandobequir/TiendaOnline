<?php

if (isset($_POST["registrar"])) {

	$usuario = [
				"Nombre" => $_POST["nombre"],				
				"Apellido" => $_POST["apellido"],
				"Direccion" => "",
				"Telefono" => "",
				"Email" => $_POST["email"],
				"Pass" => $_POST["pass"],
				];

	if (!existMailUsuario($_POST["email"])) {
		if (insertUsuario(0, $usuario)) {
			// insertado correctamente
			?>
	
				<div class="msj-ok center-small">Gracias por registrarte! Bienvenido!</div>
	
			<?php
		}
		else {
			// error!!
			?>
	
				<div class="msj-error center-small">Ups! Error de conexión. Por favor reintente en unos instantes.</div>
	
			<?php
		}
	} else {
		// mail ya existe
		?>
	
		<div class="msj-warning center-small">Ya existe una cuenta con ese email.<br><a href="?menu=ingreso">Ingresá a tu cuenta</a>o registrá otro email.</div>

	<?php
	}
	

}

?>

<div class="center-small">
	<h3>NUEVO USUARIO</h3>
	
	<form action="" method="POST">
		<div>
			<span>Nombre: <sup>*</sup></span>
			<input type="text" name="nombre" required>
		</div>
		<div>
			<span>Apellido: <sup>*</sup></span>
			<input type="text" name="apellido" required>
		</div>
		<div>
			<span>E-Mail: <sup>*</sup></span>
			<input type="text" name="email" required>
		</div>
		<div>
			<span>Contraseña: <sup>*</sup></span>
			<input type="password" name="pass">
		</div>
			<input type="submit" value="REGISTRARME" name="registrar">
			<br><br>
			<!-- <a class="crear-cuenta" href="?menu=registro-empresa"> ó crear una cuenta empresa ></a> -->
	</form>
	
</div>
