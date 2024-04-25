<?php
// Verifica si se enviaron datos antes de intentar acceder a ellos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre_apellidos']) ? $_POST['nombre_apellidos'] : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
    $ocupacion = isset($_POST['ocupacion']) ? $_POST['ocupacion'] : '';
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $ingles = isset($_POST['nivel_ingles']) ? $_POST['nivel_ingles'] : '';
    $experiencia = isset($_POST['empresa']) ? implode(', ', $_POST['empresa']) : '';
    $formacion = isset($_POST['titulo_formacion']) ? $_POST['titulo_formacion'] : array();
    $formacion = json_encode($formacion); // Convertir a JSON
    $aptitudes = isset($_POST['aptitudes']) ? $_POST['aptitudes'] : array();
    $aptitudes = implode(', ', $aptitudes); // Convertir a cadena separada por comas
}   

$hostname = "localhost";
$username = "root";
$password = ""; // Cambiar si es necesario
$database = "formulario";
$table = "usuario";

// Crear conexión
$conexion = mysqli_connect($hostname, $username, $password, $database);

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

// Verificar si la columna 'id' no existe antes de agregarla
$check_query = "SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = 'id'";
$check_result = mysqli_query($conexion, $check_query);
if ($check_result) {
    $row = mysqli_fetch_assoc($check_result);
    if ($row['count'] == 0) {
        // La columna 'id' no existe, entonces la agregamos
        $alter_query = "ALTER TABLE $table ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST";
        mysqli_query($conexion, $alter_query);
    }
} else {
    echo "Error al verificar la existencia de la columna 'id': " . mysqli_error($conexion);
}

//Insertar datos
$consulta = "INSERT INTO $table (nombre, fecha_nacimiento, ocupacion, ciudad, email, telefono, aptitudes, experiencia, formacion, ingles) 
VALUES ('$nombre','$fecha_nacimiento','$ocupacion', '$ciudad', '$email', '$telefono', '$aptitudes', '$experiencia', '$formacion', '$ingles')";

if (mysqli_query($conexion, $consulta)) {
    echo "Datos ingresados correctamente";
} else {
    echo "Error al ingresar datos: " . mysqli_error($conexion);
}

// Obtener los últimos datos insertados
$consulta = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";

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
echo "body { 
    font-family: Arial, sans-serif; 
    background-color: #f4f4f4; 
    color: #333; 
    margin: 0; 
    padding: 0; 
}";

echo ".container { 
	max-width: 800px; 
    margin: 20px auto; 
    padding: 20px; 
    background-color: #fff; 
    border-radius: 8px; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
}";

echo "h1 { 
    text-align: center; 
    color: #007bff; 
    margin-bottom: 20px; 
}";

echo "ul { 
    list-style-type: none; 
    padding: 0; 
}";

echo "li { 
    margin-bottom: 20px; 
}";

echo "li strong { 
    margin-right: 10px; 
    font-weight: bold; 
    color: #007bff; 
}";
echo "</style>";
echo "</head>";
echo "<body>";

// Mostrar los últimos datos en el CV
echo "<div class='container'>";
echo "<h1>Generado</h1>";
echo "<ul>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<li><strong>Nombre:</strong> " . $fila['nombre'] . "</li>";
    echo "<li><strong>Fecha de Nacimiento:</strong> " . $fila['fecha_nacimiento'] . "</li>";
    echo "<li><strong>Ocupación:</strong> " . $fila['ocupacion'] . "</li>";
    echo "<li><strong>Ciudad:</strong> " . $fila['ciudad'] . "</li>";
    echo "<li><strong>Email:</strong> " . $fila['email'] . "</li>";
    echo "<li><strong>Teléfono:</strong> " . $fila['telefono'] . "</li>";
    echo "<li><strong>Idioma:</strong> " . $fila['ingles'] . "</li>";
    echo "<li><strong>Aptitudes:</strong> " . $fila['aptitudes'] . "</li>";
    echo "<li><strong>Experiencia Laboral:</strong> " . $fila['experiencia'] . "</li>";
    echo "<li><strong>Formación:</strong> " . $fila['formacion'] . "</li>";
}
echo "</ul>";
echo "</div>";


mysqli_close($conexion);

echo "</body>";
echo "</html>";

?>
