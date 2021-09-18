<?php 

$database_server = 'localhost';
$database_username = 'root';
$database_password = '';
$database_name = 'blogosistema';

// Create connection using mysqli_connect()
$conn = mysqli_connect($database_server, $database_username, $database_password, $database_name);

// If $conn is false, connection is failed
if (!$conn ) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8");
// else {
    // echo "Prisijungimas ivyko sekmingai";
// }

?>