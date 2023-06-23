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

// Obtener los datos del formulario
$fecha = $_POST['fecha'];
$apellidoP = $_POST['apellidop'];
$apellidoM = $_POST['apellidom'];
$nombres = $_POST['nombres'];
$matricula = $_POST['matricula'];
$curp = $_POST['curp'];
$anios = $_POST['anios'];
$genero = $_POST['genero'];
$ecivil = $_POST['ecivil'];
$domicilio = $_POST['domicilio'];
$colonia = $_POST['colonia'];
$municipio = $_POST['municipio'];
$celular = $_POST['celular'];
$casa = $_POST['casa'];
$correo = $_POST['correo'];
$carrera = $_POST['carrera'];
$especialidad = $_POST['especialidad'];

// Preparar la consulta SQL para insertar los datos en la tabla
$consulta = "INSERT INTO egresados (fecha, apellidop, apellidom, nombres, matricula, curp, anios, genero, ecivil, domicilio, colonia, municipio, celular, casa, correo, carrera, especialidad) VALUES ('$fecha', '$apellidoP', '$apellidoM', '$nombres', '$matricula', '$curp', '$anios', '$genero', '$ecivil', '$domicilio', '$colonia', '$municipio', '$celular', '$casa', '$correo', '$carrera', '$especialidad')";

// Ejecutar la consulta
if ($conexion->query($consulta) === TRUE) {
    echo "Datos guardados correctamente.";
} else {
    echo "Error al guardar los datos: " . $conexion->error;
}
{
header("Location: Seguimiento de egresados.html"); // redirigir a la página principal para profesores
            }
// Cerrar la conexión
$conexion->close();
?>
