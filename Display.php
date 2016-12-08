<?php
    include("./Database.php");

/**
 * @desc Display product from product table by his catalog number or product name
 * @param $db_connect
 * @param $research
 * @param $option_research
 * @param $stock
 */
function displaySearchResult($db_connect, $research, $option_research, $stock){

         // Check if the research term is a number and option selected is catalog number
         if (isset($research) && is_numeric($research) && $option_research == 'catalog_number'){
             // Check if the research is restricted to product in stock
             if ($stock == 'In_stock'){
                 $request = $db_connect->prepare('SELECT * FROM product WHERE catalog_number = ? AND stock > 0');
                 $request->execute(array($research));

             } else {
                 $request = $db_connect->prepare('SELECT * FROM product WHERE catalog_number = ?');
                 $request->execute(array($research));
             }
         }
         // Check if the research term is a string and option selected is product name
         else if (isset($research) && is_string($research) &&  $option_research == 'product_name'){

             if ($stock == 'In_stock'){
                 // Find all products with a part of the searched keywords with LIKE clause and CONCAT
                 $request = $db_connect->prepare('SELECT * FROM product WHERE product_name LIKE CONCAT(\'%\',?,\'%\') AND stock > 0');
                 $request->execute(array($research));
             } else {
                 $request = $db_connect->prepare('SELECT * FROM product WHERE product_name LIKE CONCAT(\'%\',?,\'%\')');
                 $request->execute(array($research));
             }
         }

         // Display product found above from product table
         while ($data = $request->fetch()) {
             // Form => to get the data of product to add in restock table
             echo "
                    <form action='Restock.php' method='get'>
                        <tr>
                          <td> <input hidden name='catalog_number' type='text' value=" .$data['catalog_number'].">" . $data['catalog_number'] . "</td>
                          <td> <input hidden name='product_name' type='text' value=".$data['product_name'].">" . $data['product_name'] . "</td>
                          <td> <input hidden name='price' type='text' value=".$data['price'].">" . $data['price'] . "</td>
                          <td> <input hidden name='stock' type='text' value=".$data['stock'].">" . $data['stock'] . "</td>
                          <td> <input type='submit' value='Restock' /></td>
                         </tr>
                     </form>
                      ";
         }
         $request->closeCursor();

         unset($research);
     }

/**
 * @desc Display product from restock table using rows from product table using JOIN
 * @param $db_connect
 */
function displayRestockTable($db_connect) {

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
            // Form => to get the data of product to delete from the restock table
            echo "
                    <form action='Manager.php' method='get'>
                        <tr>
                          <td> <input hidden name='catalog_number' type='text' value=" .$data['catalog_number'].">" . $data['catalog_number'] . "</td>
                          <td> <input hidden name='product_name' type='text' value=".$data['product_name'].">" . $data['product_name'] . "</td>
                          <td> <input hidden name='restock_date' type='text' value=".$data['restock_date'].">" . $data['restock_date'] . "</td>
                          <td> <input type='submit' value='Delete' name='delete' /></td>
                         </tr>
                     </form>
                ";
        }
        $request->closeCursor();
    }

