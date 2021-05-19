<?php
// Si es administrador no va a comprar
if (isset($_SESSION["Usuario"]) && $_SESSION["Usuario"]["Administrador"] == 1) {
    header('location: ?menu=panel&modulo=ventas');
} ?>



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
			$marca = $producto['NombreMarca'];
			$categoria = $producto['NombreCategoria'];
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
			
			<form action="" method="POST">
				<input type="submit" value="Agregar al Carrito" name="addCart">
			</form>
			

		</div>

	<?php } ?>
</div>

<?php
// Valido que tipo de peticion invoca al modulo
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	// Compruebo si se inicio sesión
	if (!isset($_SESSION["Usuario"])) { 
		header('location: ?menu=ingreso');
		die ();
	 }
	 
    // Aca se deben procesar los datos del formulario ejecutado
	$usuario = $_SESSION["Usuario"];
	$idCliente = $usuario["Id"];
   
    if(isset($_POST['addCart'])){      
		if ($stock >= 1) {
			$carrito = SelectCarrito($idCliente);
			if ($carrito) {				
				$productoExist = false;
				$cantidadActual = 0;
				foreach ($carrito as $item) {
					if ($item["idProducto"] == $id) {
						$productoExist = true;
						$cantidadActual = $item["cantidad"];
					}
				}
				if ($productoExist) {
					UpdateCarrito($idCliente, $id, $cantidadActual + 1);
				} else {
					InsertCarrito($idCliente, $id, 1);
				}
			} else {
				InsertCarrito($idCliente, $id, 1);
			}

        header('location: ./');

		} else {
			echo ("<h2 class='msj-error'>No hay stock del producto elegido!!!</h2>");
		}
    }
} 


?>
