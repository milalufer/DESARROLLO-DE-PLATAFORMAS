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
$password='';
$base_Datos='basecv';
$tabla_nombre='usuario_info';

$conexion = mysqli_connect($hostname, $username, $password, $base_Datos);
if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}
echo "Conectado correctamente a la base de datos   ";

// Procesar habilidades y lenguajes de programación
$lenguajes = is_array($lenguajes) ? implode(", ", $lenguajes) : '';
$habilidades = is_array($habilidades) ? implode(", ", $habilidades) : '';

// Insertar datos en la tabla
$consulta  = "INSERT INTO $tabla_nombre (nombre_usu, fecha_usu, ocu_usu, contac_usu, nacional_usu, ingles_usu, lengua_usu, apti_usu, habilid_usu, perfil_usu)
        VALUES ('$nombre', '$fecha', '$ocupacion', '$contacto', '$nacionalidad', '$ingles', '$lenguajes', '$aptitudes', '$habilidades', '$perfil')";

if (mysqli_query($conexion, $consulta)) {
    echo "Datos ingresados correctamente.";
} else {
    echo "Error: " . $consulta . "<br>" . mysqli_error($conexion);
}

// Obtener los últimos datos insertados
$consulta = "SELECT * FROM $tabla_nombre ORDER BY fecha_usu DESC LIMIT 1";

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error al consultar la base de datos: " . mysqli_error($conexion));
}

// Crear la página HTML dinámicamente
echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>CV Generado</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 0; }";
echo ".container { max-width: 800px; margin: 0 auto; padding: 20px; }";
echo "h1 { text-align: center; color: #555; }";
echo "ul { list-style-type: none; padding: 0; }";
echo "li { margin-bottom: 10px; }";
echo "li strong { margin-right: 10px; font-weight: bold; color: #007bff; }";
echo "</style>";
echo "</head>";
echo "<body>";

// Mostrar los últimos datos en el CV
echo "<div class='container'>";
echo "<h1>CV Generado</h1>";
echo "<ul>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<li><strong>Nombre:</strong> " . $fila['nombre_usu'] . "</li>";
    echo "<li><strong>Fecha de Nacimiento:</strong> " . $fila['fecha_usu'] . "</li>";
    echo "<li><strong>Ocupación:</strong> " . $fila['ocu_usu'] . "</li>";
    echo "<li><strong>Contacto:</strong> " . $fila['contac_usu'] . "</li>";
    echo "<li><strong>Nacionalidad:</strong> " . $fila['nacional_usu'] . "</li>";
    echo "<li><strong>Nivel de Inglés:</strong> " . $fila['ingles_usu'] . "</li>";
    echo "<li><strong>Lenguajes de Programación:</strong> " . $fila['lengua_usu'] . "</li>";
    echo "<li><strong>Aptitudes:</strong> " . $fila['apti_usu'] . "</li>";
    echo "<li><strong>Habilidades:</strong> " . $fila['habilid_usu'] . "</li>";
    echo "<li><strong>Perfil:</strong> " . $fila['perfil_usu'] . "</li>";
}
echo "</ul>";
echo "</div>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

echo "</body>";
echo "</html>";
?>


