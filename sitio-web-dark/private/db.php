<?php
$host ='172.17.52.131';
$user = "hoteluser";
$password = "hotelpass";
$database = "Hotel_Paraiso";
$port = 3308;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
