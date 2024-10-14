<?php
$servername = "localhost"; // o tu servidor
$username = "root";
$password = "";
$dbname = "Moragas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>