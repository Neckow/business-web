<?php
// Database connection
//   $serverName = "localhost";
//   $dbname= "flowers";
//   $username="root";
//   $password= 6;

    $dbhost = 'localhost';
    $dbname = 'flowers_business';
    $dbuser = 'root';
    $dbpass = 'root';

try {
    $db_connect = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);
} catch (Exception $e) {
    die('Erreur :'. $e->getMessage());
}
?>
