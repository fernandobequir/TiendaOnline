<nav>
	<div class="contenedorPrimero">
		<h1><a href="./">Tienda Online</a></h1>
		<form class="busqueda"  action="" method="GET">
			<!-- para agregar la vista de ?menu=productos en la url -->
			<input type="hidden" name="menu" value="productos">
			<!-- concatenando el valor a buscar -->
			<input type="search" name="buscar" placeholder="Buscar...">
			<input type="submit" value="BUSCAR">
		</form>
	</div>
	
	<ul class="contenedor-segundo">
		<?php
			session_start();
			if (isset($_SESSION["Usuario"])) {
		?>

			<li class="desplegable">
				<a href="?menu=panel<?= ($_SESSION["Usuario"]["Administrador"]) ? '&modulo=ventas' : '&modulo=compras' ; ?>" class="btn-user"><strong><?= $_SESSION["Usuario"]["Nombre"]; ?></strong></a>
				<ul class="nav-user">
					
				<?php if ($_SESSION["Usuario"]["Administrador"]) { ?>
					<a href="?menu=panel&modulo=ventas">Ventas</a>
					<a href="?menu=panel&modulo=productos">Productos</a>
				<?php } ?>
					<a href="?menu=panel&modulo=compras">Compras</a>
					<a href="?menu=panel&modulo=cuenta">Cuenta</a>
					<span class="separador"></span>
					<a href="?menu=panel&sesion=cerrar">Cerrar sesión</a>					
				</ul>
			</li> |
		
		<?php } else { ?>

			<li> <a href="?menu=ingreso">INGRESAR</a> </li> |
			<li> <a href="?menu=registro">REGISTRARME</a> </li> |

		<?php } ?>
			<li> <a href="?menu=carrito">CARRITO</a> </li>
	</ul>
</nav>