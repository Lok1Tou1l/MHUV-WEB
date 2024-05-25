<?php
$dbUsername = 'root';
$dbPassword =  '';
$dbServer = 'localhost';
$dbName = 'mhuv';

$db = mysqli_connect($dbServer, $dbUsername, '', $dbName);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


?>