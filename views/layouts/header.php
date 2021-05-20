<?php
	session_start();
?>

<nav>
	<div class="contenedorPrimero">
		<h1><a href="./"><i class="fab fa-opencart" style="font-size: 32px; padding-right: 8px;"></i>Tienda Online</a></h1>
		
	<?php 
	if (!isset($_SESSION["Usuario"]) || $_SESSION["Usuario"]["Administrador"] == 0) { 
		?>
		<form class="busqueda"  action="" method="GET">
			<!-- para agregar la vista de ?menu=productos en la url -->
			<input type="hidden" name="menu" value="productos">
			<!-- concatenando el valor a buscar -->
			<input type="search" name="buscar" placeholder="Buscar...">
			<!-- <input type="submit" value="BUSCAR"> -->
			<button class="button-link" type="submit" value="buscar"><i class="fas fa-search" style="font-size: 18px;"></i></button>
		</form>
	<?php } ?>
	
	
	</div>
	
	<ul class="contenedor-segundo">
		<?php
			if (isset($_SESSION["Usuario"])) {
		?>
			<?php // MENU DESPLEGABLE ?>
			<li class="desplegable">
			<?php // Si es administrador se linkea a Ventas, sino a compras. Y se muestra el nombre de usuario ?>
				<a href="?menu=panel<?= ($_SESSION["Usuario"]["Administrador"]) ? '&modulo=ventas' : '&modulo=compras' ; ?>" class="btn-user"><i class="fas fa-user" style="font-size: 18px; padding-right: 8px;"></i><?= $_SESSION["Usuario"]["Nombre"]; ?></a>
				<ul class="nav-user">

				<?php // Si es administrador se da acceso a los modulos de administrador ?>
				<?php if ($_SESSION["Usuario"]["Administrador"]) { ?>
					<a href="?menu=panel&modulo=ventas">Ventas</a>
					<a href="?menu=panel&modulo=productos">Productos</a>
				<?php } else {?>
				<?php // Acceso a usuarios que no son administrador ?>
					<a href="?menu=panel&modulo=compras">Compras</a>
				<?php } ?>
				<?php // Acceso al resto de los modulos para todos los tipos de usuario ?>
					<a href="?menu=panel&modulo=cuenta">Cuenta</a>
					<span class="separador"></span>
					<a href="?menu=panel&sesion=cerrar">Cerrar sesión</a>					
				</ul>
			</li>
		
		<?php } else { ?>

			<li> <a href="?menu=ingreso">Ingresar</a> </li> |
			<li> <a href="?menu=registro">Registrarme</a> </li>

		<?php } ?>
		<?php if (!isset($_SESSION["Usuario"]) || $_SESSION["Usuario"]["Administrador"] == 0) { ?>
			| <li> <a href="?menu=carrito" title="Carrito" style="position:relative">
				<i class="fas fa-shopping-cart" style="font-size: 18px; padding-right: 10px;">
				
				<?php // Compruebo si se inicio sesión
					if (isset($_SESSION["Usuario"])) { 
						$usuario = $_SESSION["Usuario"];
						$idCliente = $usuario["Id"];
						$productosCarrito = SelectCarrito($idCliente);
						// compruebo si el usuario tiene productos en carrito
						if (!empty($productosCarrito)) { ?>
					<i class="fas fa-circle" style="position:absolute; color:crimson; font-size:0.6em; left:24px; top:13px"></i>
					<span style="position:absolute; color:#777; font-size:0.8em; left:17px; top:18px"><?= count($productosCarrito) ?></span>
				<?php } } ?>

				</i>				
			</a> </li>
		<?php } ?>
	</ul>
</nav>


