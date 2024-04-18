<?php

$nombre = isset($_POST['nombre_apellidos']) ? $_POST['nombre_apellidos'] : '';
$fecha = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
$ocupacion = isset($_POST['ocupacion']) ? $_POST['ocupacion'] : '';
$contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
$nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : '';
$ingles = isset($_POST['nivel_ingles']) ? $_POST['nivel_ingles'] : '';
$lenguajes = isset($_POST['lenguajes_programacion']) ? $_POST['lenguajes_programacion'] : array();
$aptitudes = isset($_POST['aptitudes']) ? $_POST['aptitudes'] : '';
$habilidades = isset($_POST['habilidades']) ? $_POST['habilidades'] : array();
$perfil = isset($_POST['perfil']) ? $_POST['perfil'] : '';

//CONEXION
$hostname='localhost';
$username='root';
$password=''; // Aquí debes poner tu contraseña si la tienes
$base_Datos='basecv';
$tabla_nombre='usuario_info';

$conexion = mysqli_connect($hostname, $username, $password, $base_Datos);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}
echo "Conectado correctamente a la base de datos   ";

// Insertar datos en la tabla
$consulta  = "INSERT INTO $tabla_nombre (nombre_usu, fecha_usu, ocu_usu, contac_usu, nacional_usu, ingles_usu, lengua_usu, apti_usu, habilid_usu, perfil_usu)
        VALUES ('$nombre', '$fecha', '$ocupacion', '$contacto', '$nacionalidad', '$ingles', '".implode(",", $lenguajes)."', '$aptitudes', '".implode(",", $habilidades)."', '$perfil')";

if (mysqli_query($conexion, $consulta)) {
    echo "Datos ingresados correctamente.";
}

