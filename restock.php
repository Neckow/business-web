<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <?php
        include('./Navbar.php');

        /*    header("Location: http://localhost:8888/Business_web/home.php");*/
        $catalog_number = $_GET['catalog_number'];
        $stock = $_GET['stock'];

        restock($catalog_number, $stock);
        displayRestockTable();
    exit;
    ?>

    <?php


    function displayRestockTable() {
        include('./database.php');
        $request = $db_connect->prepare('SELECT product.catalog_number,product.product_name, restock.restock_date  
                                          FROM restock INNER JOIN product
                                          ON product.catalog_number=restock.catalog_number');
        $request->execute();

        echo "
            <table>
            <tr>
                <th>Catalog Number</th>
                <th>Product Name</th>
                <th>Restock Date</th>
                <th>Deletion</th>
            </tr>
        ";
        while ($data = $request->fetch()) {
            echo "
                <form action='./delete.php' method='get'>
                    <tr>
                      <td> <input hidden name='catalog_number' type='text' value=".$data['catalog_number'].">" . $data['catalog_number'] . "</td>
                      <td> <input hidden name='product_name' type='text' value=".$data['product_name'].">" . $data['product_name'] . "</td>
                      <td> <input hidden name='restock_date' type='text' value=".$data['restock_date'].">" . $data['restock_date'] . "</td>
                      <td> <input type='submit' value='Delete' name='delete' /></td>
                     </tr>
                 </form>
            ";
        }
        $request->closeCursor();
    }

    /*
      * @desc Search product by catalog_number in restock table and add it if not found and stock = 0
      * @param int $catalog_number, $stock
      * @return string msg - success or fail
     */
    function restock($catalog_number, $stock){
        include('./database.php');

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
        else {
            echo "This product is still a stock.";
        }
        /*$request->closeCursor();*/
    }
    ?>

    </body>
</html>
