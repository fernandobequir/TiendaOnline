<?php

	if (isset($_POST['login'])) {
		if (isset($_POST['email']) && isset($_POST['pass'])) {
			$email = $_POST['email'];
			$pass = $_POST["pass"];
		
			$usuario = loginUsuario($email, $pass);

			if ($usuario) {        
				// acceso correcto
				session_start();
		
				$_SESSION["Usuario"] = array(
					"Id" => $usuario["idUsuario"],
					"Nombre" => ($usuario["Nombre"]) ? $usuario["Nombre"] : $usuario["RazonSocial"] ,
					"Apellido" => $usuario["Apellido"],
					"Email" => $usuario["Email"],
					"Administrador" => $usuario['Rol']
				);
		
				if ($usuario['Rol']) {
					header("location: ?menu=panel&modulo=ventas");
				} else {
					header("location: ./");
				}
			} else {
				// acceso incorrecto
?>

				<div class="msj-error center-small">Revisá tu e‑mail o contraseña.</div>

<?php
			}
		}
	}

?>


<div class="center-small">
	<h3>INGRESO DE USUARIO</h3>
	<form action="" method="POST">
		<div>
			<span>E-Mail:</span>
			<input type="text" name="email" required>
		</div>
		<div>
			<span>Contraseña:</span>
			<input type="password" name="pass" required>
		</div>
		<input type="submit" value="INGRESAR" name="login">
		<a class="crear-cuenta" href="#">¿Olvidaste tu contraseña?</a>
	</form>
	<h4 class="nuevo-usuario">¿NUEVO USUARIO?</h4>
	<a class="button-link button-border" href="?menu=registro">CREAR CUENTA</a>
</div>
