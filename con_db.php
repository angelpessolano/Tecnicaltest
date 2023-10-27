<?php

// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$database = "midcenturywareho_psdb2";

$mysqli = new mysqli($host, $username, $password, $database);

// Comprobación de la conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Impresión de información de la conexión
//echo "Host test: " . $mysqli->host_info . PHP_EOL;
//echo "Version: " . $mysqli->server_version . PHP_EOL;

// Cierre de la conexión
//$mysqli->close();

?>