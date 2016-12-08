<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <?php

        include('./Navbar.php');
        include('./Display.php');
        include('./Manager.php');

        $catalog_number = $_GET['catalog_number'];
        $stock = $_GET['stock'];

        restock($db_connect, $catalog_number, $stock);
        displayRestockTable($db_connect);
    exit;
    ?>

    </body>
</html>
