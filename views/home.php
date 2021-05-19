<?php 
// Si es administrador no va a comprar
if (isset($_SESSION["Usuario"]) && $_SESSION["Usuario"]["Administrador"] == 1) {
    header('location: ?menu=panel&modulo=ventas');
}
?>	
	
	<!-- PRODUCTOS DESTACADOS -->
	<div class="center">
	    <div class="productos">
	        <h3>PRODUCTOS DESTACADOS</h3>
	        <a class="view-all" href="?menu=productos&buscar=productos-destacados">Ver todos</a>
	    </div>
	    <div class="grid-productos">

	        <!-- Productos -->
			<?php 
				$productos = selectProductos('productos-destacados','' , 1, 4);

				foreach ($productos as $producto) {
					$id = $producto['idProducto'];
					$nombre = $producto['Nombre'];
					$precio = $producto['Precio'];
					$imagen = $producto['Imagen'];
			?>

					<div class="item-grid-productos">
						<a href="?menu=producto&item=<?= $id ?>">
							<img class="img-grid-productos" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>" />
							<div class="detalle-grid-productos">
								<span>$ <?= $precio ?></span>
								<p><?= $nombre ?></p>
							</div>
						</a>
					</div>

			<?php } ?>

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
			<?php 
				$productos = selectProductos('todos-los-productos', '', 1, 4);

				foreach ($productos as $producto) {
					$id = $producto['idProducto'];
					$nombre = $producto['Nombre'];
					$precio = $producto['Precio'];
					$imagen = $producto['Imagen'];
			?>

					<div class="item-grid-productos">
						<a href="?menu=producto&item=<?= $id ?>">
							<img class="img-grid-productos" src="img/productos/<?= $imagen ?>" alt="<?= $nombre ?>" />
							<div class="detalle-grid-productos">
								<span>$ <?= $precio ?></span>
								<p><?= $nombre ?></p>
							</div>
						</a>
					</div>

			<?php } ?>

	    </div>
	</div>