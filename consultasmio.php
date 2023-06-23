<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perfilegreso";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener el valor del formulario
//$nombres = $_POST["nombre"];
$matricula = $_POST["matricula"];

// Consultar la base de datos
/*$sql = "SELECT * FROM egresados WHERE matricula = '$matricula'";
$result = $conn->query($sql);*/

$sql = "SELECT* FROM egresados WHERE matricula = '$matricula'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Mostrar los resultados en una tabla
    echo "<table>";
    echo "<tr><th>Matricula</th>
    <th>Nombre</th>
    <th>Apellido Paterno</th>
    <th>Apellido Materno</th>
    <th>Genero</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["matricula"]."</td>";
        echo "<td>".$row["nombres"]."</td>";
        echo "<td>".$row["apellidoP"]."</td>";
        echo "<td>".$row["apellidoM"]."</td>";
        echo "<td>".$row["genero"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>
