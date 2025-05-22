<?php
$host ='mysql-db';
$user = "hoteluser";
$password = "hotelpass";
$database = "Hotel_Paraiso";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
