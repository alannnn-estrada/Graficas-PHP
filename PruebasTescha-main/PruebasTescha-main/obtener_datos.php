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

// Consultar los datos de la base de datos
$sql = "SELECT carrera, COUNT(*) AS cantidad FROM encuestas GROUP BY carrera";
$result = mysqli_query($connection, $sql);

// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    // Enviar los datos como respuesta en formato JSON
    echo json_encode($data);
} else {
    echo "No se encontraron datos.";
}

// Cerrar la conexión
mysqli_close($connection);
?>
