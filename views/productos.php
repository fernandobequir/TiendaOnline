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
    $ordenRef = '&order=' . $orden;
} else {
    $orden = '';
    $ordenRef = '';
}

$cantidad_productos = countProductos($filtro);

$limite = 2;

$paginas_total = ceil($cantidad_productos / $limite);


// Decoración del orden activo (se puede hacer en JS)
switch ($orden) {
    case 'menor-precio':
        $activeMenor = 'active';
        break;
    case 'mayor-precio':
        $activeMayor = 'active';
        break;
    default:
        $activeDefault = 'active';
        break;
}

?>



<div class="productos">
    <!-- nav productos -->
    <div class="center">
        <h4><?= $filtro ?> - <span><?= $cantidad_productos ?> items</span></h4>
        <ul class="order-nav">
            <li>Ordernar por: </li>
            <li><a class="<?= $activeDefault ?>" href="?menu=productos&buscar=<?= $filtro ?>">Más recientes</a></li> |
            <li><a class="<?= $activeMenor ?>" href="?menu=productos&buscar=<?= $filtro ?>&order=menor-precio">Menor precio</a></li> |
            <li><a class="<?= $activeMayor ?>" href="?menu=productos&buscar=<?= $filtro ?>&order=mayor-precio">Mayor precio</a></li>
        </ul>
    </div>
    <!-- productos -->
    <div class="grid-productos center">

        <!-- Productos -->
        <?php selectProductos($filtro, $orden, $pagina, $limite); ?>

    </div>
    
    <!-- paginador -->
    <ul class="paginador">
                        
        <?php if ($pagina != 1) { ?>

            <li><a href="?menu=productos&buscar=<?= $filtro ?>&pag=<?= $pagina - 1 ?><?= $ordenRef ?>">< Anterior</a> </li>
        
        <?php } ?>

        <?php for ($i = 1; $i <= $paginas_total; $i++) {
            // Decoración de la página activa (se puede hacer en JS)
            if ($pagina == $i){
                $num = "<b>$i</b>";
            } else {
                $num = $i;
            }
            ?>
        
            <li><a href="?menu=productos&buscar=<?= $filtro ?>&pag=<?= $i ?><?= $ordenRef ?>"><?= $num ?></a></li>

        <?php } ?>

        <?php if ($pagina != $paginas_total) { ?>

            <li><a href="?menu=productos&buscar=<?= $filtro ?>&pag=<?= $pagina + 1 ?><?= $ordenRef ?>">Siguiente ></a></li>

        <?php } ?>

    </ul>
</div>