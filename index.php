<?php require_once ('config/loader.php') ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="shortcut icon" href="img/favicon2.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
</head>
<body>
    <header>
        <?php include_once ('views/layouts/header.php') ?> 
    </header>
    <main>
        <?php include_once ('config/routing.php') ?> 
    </main>
    <footer>
        <?php include_once ('views/layouts/footer.php') ?> 
    </footer>
</body>
</html>