<?php
// Valido que el usuario sea administrador
if (!$_SESSION["Usuario"]["Administrador"]) {
    header('location: ./');
}

// Valido que haya una accion a realizar, sino se irá a crear un nuevo producto
if( isset( $_GET["action"] ) ){
    $action = $_GET["action"];
} else {
    $action = "add";
}

// Valido que tipo de peticion invoca al modulo
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    // Aca se deben procesar los datos del formulario ejecutado
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $precio =  $_POST["precio"];
    $marca =  $_POST["marca"];
    $categoria =  $_POST["categoria"];
    $presentacion =  $_POST["presentacion"];
    $stock =  $_POST["stock"];

    $imagen = $_FILES["imagen"];
    $imagenNombre = $imagen["name"];
    $imagenActual = $_POST["imagenActual"];
    
    $directorio = "img/productos/" . $imagenNombre;

    switch ($action) {
        case 'add':

            $msj = "0x1000";
            $affectedRows = InsertProducto($nombre, $precio, $marca, $categoria, $presentacion, $stock, $imagenNombre);
            if($affectedRows > 0){
                $msj = "0x10";
                if( !empty($imagenNombre) ){
                    if( move_uploaded_file( $imagen["tmp_name"], $directorio ) == false ){
                        $msj = "0x11";
                    }
                }
            }
        break;
        
        case 'update':

            $msj = "0x20";

            if( !empty($imagenNombre) ){
                if( move_uploaded_file( $imagen["tmp_name"], $directorio ) == true ){
                    $sqlImagen = $imagenNombre;
                    unlink( "img/productos/" . $imagenActual );
                } else {
                    $msj = "0x21";
                }
            } else {
                $sqlImagen = $imagenActual;
            }

            $affectedRows = UpdateProducto($id, $nombre, $precio, $marca, $categoria, $presentacion, $stock, $sqlImagen);
            if($affectedRows == 0){
                $msj = "0x1000";
            }
        break;
        
        case 'delete':
            
            $msj = "0x1000";

            if ( DeleteProducto($id) > 0 ) {        
                unlink( "img/productos/" . $imagenActual );
                $msj = "0x30";
            }
        break;
    }
    header('location: ?menu=panel&modulo=productos&msj='. $msj);

} else {
    // Preparar el formulario para: Agregar - Modificar - Eliminar
    switch ($action) {
        case 'add':
            $btn = "Agregar";
            $status = null;
            $producto = array(
                "idProducto" => "",
                "Nombre" => "",
                "Precio" => "",
                "Marca" => "",
                "Categoria" => "",
                "Presentacion" => "",
                "Stock" => ""
            );
        break;
        
        case 'update':
            $id = $_GET["id"];
            $btn = "Actualizar";
            $status = null;
            $producto = selectProducto( $id );
        break;

        case 'delete':
            $id = $_GET["id"];
            $btn = "Eliminar";
            $status = "disabled";
            $producto = selectProducto( $id );
        break;
    }
}
?>


<div class="main">
<form action="?menu=panel&modulo=producto&action=<?= $action ?>" method="POST" enctype="multipart/form-data">
Nombre:
<br>
<input type="text" name="nombre" value="<?= $producto["Nombre"] ?>" <?= $status ?>>
<br>
Precio:
<br>
<input type="number" min="0" step="0.5" name="precio" value="<?= $producto["Precio"] ?>" <?= $status ?>>
<br>
Marca:
<br>
<select name="marca" required <?= $status; ?>>
    <option value="">Elija una marca...</option>

    <?php
        $marcas = selectMarcas();
        foreach ($marcas as $marca) {
            $idMarca = $marca["idMarca"];
            $nombre = $marca["Nombre"];
            $marca = $producto["Marca"];
    ?>

        <option value="<?= $idMarca ?>" <?= ($idMarca == $marca) ? "selected" : null ?>> <?= $nombre ?> </option>

    <?php } ?>
</select>
<br>
Categoria:
<br>
<select name="categoria" required <?= $status; ?>>
    <option value="">Elija una categoria...</option>

    <?php
        $categorias = selectCategorias();
        foreach ($categorias as $categoria) {
            $idCategoria = $categoria["idCategoria"];
            $nombre = $categoria["Nombre"];
            $categoria = $producto["Categoria"];
    ?>
        <option value="<?= $idCategoria ?>" <?= ($idCategoria == $categoria) ? "selected" : null ?>> <?= $nombre ?> </option>

    <?php } ?>

</select>
<br>
Presentacion:
<br>
<input type="text" name="presentacion" value="<?= $producto["Presentacion"]; ?>" <?= $status ?>>
<br>
Stock:
<br>
<input type="number" min="0" name="stock" value="<?= $producto["Stock"]; ?>" <?= $status ?>>
<br>

<br>
Imagen:
<div style="width:100px">
    <?php if(!empty( $producto["Imagen"]) ) : ?>
        <img id="previewImg" src="img/productos/<?= $producto["Imagen"]; ?>" style="max-width:100%">
    <?php else: ?>
        <img id="previewImg" src="" style="max-width:100%">
    <?php endif; ?>
</div>



<?php
if ($btn === "Eliminar") {
   $style = "background-color:crimson;";
   $styleImage = "display: none;";
}
?>

<input type="file" name="imagen" id="selectImg" accept="image/*" <?= $status ?>>
<label for="selectImg" class="button-link button-border" style="<?= $styleImage; ?>">Elegir imagen</label>
<br>
<br>
<br>
<input type="submit" value="<?= $btn; ?>" style="<?= $style; ?>">
<?php if( isset($id) ){ ?>
<input type="hidden" name="id" value="<?= $producto["idProducto"]; ?>">
<input type="hidden" name="imagenActual" value="<?= $producto["Imagen"]; ?>">
<?php } ?>
</form>
</div>

<?php //142 Origin
//179 ?>


<script>
    // Obtener referencia al input y a la imagen
    const $seleccionArchivos = document.querySelector("#selectImg");
    const $imagenPrevisualizacion = document.querySelector("#previewImg");

    // Escuchar cuando cambie
    $seleccionArchivos.addEventListener("change", () => {
    // Los archivos seleccionados, pueden ser muchos o uno
    const archivos = $seleccionArchivos.files;
    // Si no hay archivos salimos de la función y quitamos la imagen
    if (!archivos || !archivos.length) {
        $imagenPrevisualizacion.src = "";
        return;
    }
    // Ahora tomamos el primer archivo, el cual vamos a previsualizar
    const primerArchivo = archivos[0];
    // Lo convertimos a un objeto de tipo objectURL
    const objectURL = URL.createObjectURL(primerArchivo);
    // Y a la fuente de la imagen le ponemos el objectURL
    $imagenPrevisualizacion.src = objectURL;
    });
</script>