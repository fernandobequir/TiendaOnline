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
	
	<ul>
		<li> <a href="?menu=ingreso">INGRESAR</a> </li> |
		<li> <a href="?menu=registro">REGISTRARME</a> </li> |
		<li> <a href="?menu=contacto">CONTACTO</a> </li>
	</ul>
</nav>