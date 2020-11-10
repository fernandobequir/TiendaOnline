<?php

    if (isset($_GET['buscar'])) {
        $filtro = $_GET['buscar'];
        if ($filtro == '') {
            $filtro = 'todos-los-productos';
        }
    }
    if (isset($_GET['pag'])) {
        $pagina = $_GET['pag'];
    } else {
        $pagina = 1;
    }
    if (isset($_GET['order'])) {
        $orden = $_GET['order'];
    } else {
        $orden = '';
    }

    $cantidad_productos = countProductos($filtro);

    $limite = 4; // CANTIDAD DE PRODUCTOS POR PÁGINA

    $paginas_total = ceil($cantidad_productos / $limite);

?>


<div class="productos">
    <!-- nav productos -->
    <div class="center">
        <h4><?= $filtro ?> - <span><?= $cantidad_productos ?> items</span></h4>
        
        <?php if ($cantidad_productos > 1) { ?>

            <ul class="order-nav">
                <li>Ordenar por: </li>
                <li><a class="<?= ($orden == '') ? 'active' : '' ; ?>" href="?menu=productos&buscar=<?= $filtro ?>">Más recientes</a></li> |
                <li><a class="<?= ($orden == 'menor-precio') ? 'active' : '' ; ?>" href="?menu=productos&buscar=<?= $filtro ?>&order=menor-precio">Menor precio</a></li> |
                <li><a class="<?= ($orden == 'mayor-precio') ? 'active' : '' ; ?>" href="?menu=productos&buscar=<?= $filtro ?>&order=mayor-precio">Mayor precio</a></li>
            </ul>
            
        <?php } ?>

    </div>

    <!-- productos -->
    <div class="grid-productos center">

        <!-- Producto -->
        <?php
            $productos = selectProductos($filtro, $orden, $pagina, $limite);
                
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
    
    <!-- paginador -->
    <?php if ($paginas_total > 1) { ?>
        <ul class="paginador">
                            
            <?php if ($pagina != 1) { ?>

                <li><a href="?menu=productos&buscar=<?= $filtro ?><?= ($orden == '') ? '' : '&order='.$orden ; ?>&pag=<?= $pagina - 1 ?>">< Anterior</a></li>
            
            <?php } ?>

            <?php for ($i = 1; $i <= $paginas_total; $i++) { ?>
            
                <li><a class="<?= ($pagina == $i) ? 'active' : '' ; ?>" href="?menu=productos&buscar=<?= $filtro ?><?= ($orden == '') ? '' : '&order='.$orden ; ?>&pag=<?= $i ?>"><?= $i ?></a></li>

            <?php } ?>

            <?php if ($pagina != $paginas_total) { ?>

                <li><a href="?menu=productos&buscar=<?= $filtro ?><?= ($orden == '') ? '' : '&order='.$orden ; ?>&pag=<?= $pagina + 1 ?>">Siguiente ></a></li>

            <?php } ?>

        </ul>
    <?php } ?>

</div>