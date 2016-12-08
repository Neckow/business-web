<?php

    // Go back to restock page
    header("Location: http://localhost:8888/Business_web/Restock.php");

    include('./Database.php');

    // Delete From restock table by catalog_number
    delete($db_connect, $_GET['catalog_number']);


/**
 * @desc delete a product from restock table
 * @param $db_connect
 * @param $catalog_number
 */
function delete($db_connect, $catalog_number){
        if (isset($catalog_number)) {
            $request = $db_connect->prepare('DELETE FROM restock WHERE catalog_number = ?');
            $request->execute(array($catalog_number));
            $request->closeCursor();
        }
    }


/**
 * @desc Search product by catalog_number in restock table and add it if not found and stock = 0
 * @param int $catalog_number, $stock
 * @param $db_connect
 * @return string msg - success or fail
**/
function restock($db_connect, $catalog_number, $stock){

    if (isset($catalog_number) && $stock == 0){

        $request = $db_connect->prepare('SELECT * FROM restock WHERE catalog_number = ?');
        $request->execute(array($catalog_number));
        $data = $request->fetch();

        if ($data['catalog_number'] != $catalog_number){
            $request = $db_connect->prepare("INSERT INTO restock(restock_id, catalog_number, restock_date) VALUES ('', ?, NOW())");
            $request->execute(array($catalog_number));

            echo "Product added successfully.";
        }
        else {
            echo "This product is already in restocking ";
        }
    }
    else if ($stock == 0) {
        echo "This product is still a stock.";
    }
    /*$request->closeCursor();*/
}

/*function RestockAll($db_connect){
    $request = $db_connect->prepare("INSERT INTO restock_id, catalog_number, restock_date) VALUES ('', ?, NOW()) WHERE ");
    $request->execute();
}*/