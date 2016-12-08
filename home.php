<html>
    <head>
        <?php
            include('./Navbar.php');
            include('./database.php');
            include('./form.php');
        ?>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <table>
            <tr>
                <th>Catalog Number</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Select</th>
            </tr>
            <?php

            if (isset($_GET['research']) && is_numeric($_GET['research']) && $_GET['option_research'] == 'catalog_number'){
                if ($_GET['stock'] == 'In_stock'){
                    $request = $db_connect->prepare('SELECT * FROM product WHERE catalog_number = ? AND stock > 0');
                    $request->execute(array($_GET['research']));

                } else {
                    $request = $db_connect->prepare('SELECT * FROM product WHERE catalog_number = ?');
                    $request->execute(array($_GET['research']));
                }
            }
            else if (isset($_GET['research']) && is_string($_GET['research']) &&  $_GET['option_research'] == 'product_name'){

                if ($_GET['stock'] == 'In_stock'){
                    $request = $db_connect->prepare('SELECT * FROM product WHERE product_name LIKE CONCAT(\'%\',?,\'%\') AND stock > 0');
                    $request->execute(array($_GET['research']));
                } else {
                    $request = $db_connect->prepare('SELECT * FROM product WHERE product_name LIKE CONCAT(\'%\',?,\'%\')');
                    $request->execute(array($_GET['research']));
                }
            }
            else {
                echo "Please fill the field";
                echo "<br>";
            }

            /*
             * @desc Display product from product table
            */

            while ($data = $request->fetch()) {
                echo "
                        <form action='./restock.php' method='get'>
                            <tr>
                              <td> <input hidden name='catalog_number' type='text' value=".$data['catalog_number'].">" . $data['catalog_number'] . "</td>
                              <td> <input hidden name='product_name' type='text' value=".$data['product_name'].">" . $data['product_name'] . "</td>
                              <td> <input hidden name='price' type='text' value=".$data['price'].">" . $data['price'] . "</td>
                              <td> <input hidden name='stock' type='text' value=".$data['stock'].">" . $data['stock'] . "</td>
                              <td> <input type='submit' value='Restock' /></td>
                             </tr>
                         </form>
                          ";
            }
            $request->closeCursor();

            unset($_GET['research']);
            ?>
            </tr>
        </table>
        <br/><br/>
    </body>
</html>
