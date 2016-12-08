<html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Welcome to the Business Website</title>
        <?php
            include('./Navbar.php');
            include('./Form.php');
            include('./Display.php')
        ?>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h3>Welcome to the Business Website</h3>

        </br>
        <form action="./Manager.php" method="get" >
            <input type='submit' value='Restock All' />
        </form>
        </br>
            <table>
                <tr>
                    <th>Catalog Number</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Select</th>
                </tr>
                <?php
                    displaySearchResult($db_connect, $_GET['research'], $_GET['option_research'], $_GET['stock']);
                ?>
                </tr>
            </table>
        <br/>

    </body>
</html>
