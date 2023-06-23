<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'perfilegreso';

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener las opciones seleccionadas del formulario
$genero = $_POST['genero'];
$ecivil = $_POST['ecivil'];
$carrera = $_POST['carrera'];
$especialidad = $_POST['especialidad'];

// Preparar la consulta SQL para obtener la cantidad de hombres y mujeres según las opciones seleccionadas
$consulta = "SELECT genero, COUNT(*) AS cantidad FROM egresados WHERE ecivil IN ('$ecivil') AND carrera IN ('$carrera') AND especialidad IN ('$especialidad')";

// Agregar la condición del género si no se selecciona "todos"
if ($genero !== "todos") {
    $consulta .= " AND genero IN ('$genero')";
}

// Agregar el agrupamiento por género si no se selecciona un género específico
if ($genero === "" || $genero === "todos") {
    $consulta .= " GROUP BY genero";
}

// Ejecutar la consulta
$resultado = $conexion->query($consulta);

if ($resultado) {
    $valores = [0, 0]; // Inicializar los valores en 0 para hombres y mujeres
    $colores = [];

    // Obtener los datos de la consulta
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['genero'] === 'hombre') {
            $valores[0] = $fila['cantidad']; // Actualizar el valor de hombres
            $colores[] = '#36A2EB'; // Color para hombres
        } else {
            $valores[1] = $fila['cantidad']; // Actualizar el valor de mujeres
            $colores[] = '#FF6384'; // Color para mujeres
        }
    }

    // Crear la estructura de la respuesta JSON
    $respuesta = [
        'valores' => $valores,
        'colores' => $colores
    ];

    // Convertir la respuesta a formato JSON
    $jsonRespuesta = json_encode($respuesta);

    // Imprimir la respuesta JSON para enviarla al cliente
    header('Content-Type: application/json');
    echo $jsonRespuesta;
} else {
    echo "Error al ejecutar la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>
