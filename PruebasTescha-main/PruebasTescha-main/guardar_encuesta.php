<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tescha";

// Establecer la conexión
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$connection) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Obtener los datos del formulario
$nombre = $_POST["nombre"];
$edad = $_POST["edad"];
$carrera = $_POST["carrera"];
$experiencia = $_POST["experiencia"];

// Prevenir inyección de SQL escapando las variables
$nombre = mysqli_real_escape_string($connection, $nombre);
$carrera = mysqli_real_escape_string($connection, $carrera);
$experiencia = mysqli_real_escape_string($connection, $experiencia);

// Insertar los datos en la base de datos
$sql = "INSERT INTO encuestas (nombre, edad, carrera, experiencia) VALUES ('$nombre', $edad, '$carrera', '$experiencia')";

if (mysqli_query($connection, $sql)) {
    echo "Encuesta guardada exitosamente.";
} else {
    echo "Error al guardar la encuesta: " . mysqli_error($connection);
}

// Cerrar la conexión
mysqli_close($connection);
?>
