	<div class="center grid-productos">
		
	<!-- producto -->
	<?php 

	if (isset($_GET['item'])) {
		$id = $_GET['item'];
	}
	
	selectProducto($id)	

	?>

	</div>