<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "colegio";


$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos);


if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}


function cerrar_conexion($conexion) {
    mysqli_close($conexion);
}
?>
