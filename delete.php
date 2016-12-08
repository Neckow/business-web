<?php

    header("Location: http://localhost:8888/Business_web/restock.php");

    include('./database.php');


    if (isset($_GET['catalog_number'])) {
        $request = $db_connect->prepare('DELETE FROM restock WHERE catalog_number = ?');
        $request->execute(array($_GET['catalog_number']));
        $request->closeCursor();

    }
?>