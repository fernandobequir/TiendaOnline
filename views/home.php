	<!-- PRODUCTOS DESTACADOS -->
	<div class="center">
	    <div class="productos">
	        <h3>PRODUCTOS DESTACADOS</h3>
	        <a class="view-all" href="?menu=productos&buscar=productos-destacados">Ver todos</a>
	    </div>
	    <div class="grid-productos">

	        <!-- Productos -->
	        <?php selectProductos('productos-destacados','' , 1, 4); ?>

	    </div>
	</div>
	<!-- ULTIMOS PRODUCTOS -->
	<div class="center">
	    <div class="productos">
	        <h3>ULTIMOS PRODUCTOS</h3>
	        <a class="view-all" href="?menu=productos&buscar=todos-los-productos">Ver todos</a>
	    </div>
	    <div class="grid-productos">

	        <!-- Productos -->
	        <?php selectProductos('todos-los-productos', '', 1, 4); ?>

	    </div>
	</div>