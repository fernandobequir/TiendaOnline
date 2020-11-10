	<div class="center grid-productos">
		
		<!-- producto -->
		<?php
			if (isset($_GET['item'])) {
				$id = $_GET['item'];
			}
			
			$producto = selectProducto($id);

			if ($producto) {
				$id = $producto['idProducto'];
				$nombre = $producto['Nombre'];
				$precio = $producto['Precio'];
				$marca = $producto['Marca'];
				$categoria = $producto['Categoria'];
				$presentacion = $producto['Presentacion'];
				$descripcion = $producto['Descripcion'];
				$stock = $producto['Stock'];
				$imagen = $producto['Imagen'];		
		?>

			<img class="detalle-imagen" src="img/productos/<?= $imagen ?>" />
			<div class="detalle-descripcion">
				<h2><?= $nombre ?></h2>
				<h2 class="precio">$ <?= $precio ?></h2>
				<h4 class="stock"><?= $stock ?> unid. en stock</h4>
				<p><?= "Categoría: $categoria | Marca: $marca | Presentación: $presentacion" ?></p>
				<p><?= $descripcion ?></p>
				<a class="button-comprar" href="#">COMPRAR</a>
			</div>

		<?php } ?>
	</div>