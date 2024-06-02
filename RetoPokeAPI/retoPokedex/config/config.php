<?php
// Definición de las variables de conexión a la base de datos
$host = "localhost";   // Dirección del servidor de la base de datos
$username = "root";    // Nombre de usuario para acceder a la base de datos
$password = "";        // Contraseña del usuario para acceder a la base de datos
$dbname = "pokemon_db"; // Nombre de la base de datos a la que se desea conectar

// Creación de la conexión a la base de datos utilizando mysqli
$conn = new mysqli($host, $username, $password, $dbname);

// Verificación de la conexión a la base de datos
if ($conn->connect_error) {
    // Si hay un error en la conexión, se muestra un mensaje de error y se detiene la ejecución del script
    die("Conexión fallida: " . $conn->connect_error);
}

// Si la conexión es exitosa, el script continuará ejecutándose
?>