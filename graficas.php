<?php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'perfilegresados';

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

if (!$conexion) {
    die('Error al conectar a la base de datos');
}

$genero = $_POST['genero'];
$estadoCivil = $_POST['ecivil'];

$consultaTotal = "SELECT COUNT(*) AS total FROM egresados";
$resultadoTotal = mysqli_query($conexion, $consultaTotal);
$rowTotal = mysqli_fetch_assoc($resultadoTotal);
$totalRegistros = $rowTotal['total'];

if ($genero !== "todos") {
    $consultaSeleccionada = "SELECT COUNT(*) AS total_seleccionado FROM egresados WHERE genero = '$genero'";
    if (!empty($estadoCivil)) {
        $consultaSeleccionada .= " AND ecivil = '$estadoCivil'";
    }
    $resultadoSeleccionado = mysqli_query($conexion, $consultaSeleccionada);
    $rowSeleccionado = mysqli_fetch_assoc($resultadoSeleccionado);
    $totalSeleccionado = $rowSeleccionado['total_seleccionado'];
} else if ($genero == "todos") {
    $consultaSeleccionada = "SELECT COUNT(*) AS total_seleccionado FROM egresados";
    if (!empty($estadoCivil)) {
        $consultaSeleccionada .= " WHERE ecivil = '$estadoCivil'";
    }

    $consultaSeleccionadaMujer = "SELECT COUNT(*) AS total_seleccionado FROM egresados WHERE genero = 'mujer'";
    if (!empty($estadoCivil)) {
        $consultaSeleccionadaMujer .= " AND ecivil = '$estadoCivil'";
    }
    $resultadoSeleccionadoMujer = mysqli_query($conexion, $consultaSeleccionadaMujer);
    $rowSeleccionadoMujer = mysqli_fetch_assoc($resultadoSeleccionadoMujer);
    $totalSeleccionadoMujer = $rowSeleccionadoMujer['total_seleccionado'];

    $consultaSeleccionadaHombre = "SELECT COUNT(*) AS total_seleccionado FROM egresados WHERE genero = 'hombre'";
    if (!empty($estadoCivil)) {
        $consultaSeleccionadaHombre .= " AND ecivil = '$estadoCivil'";
    }
    $resultadoSeleccionadoHombre = mysqli_query($conexion, $consultaSeleccionadaHombre);
    $rowSeleccionadoHombre = mysqli_fetch_assoc($resultadoSeleccionadoHombre);
    $totalSeleccionadoHombre = $rowSeleccionadoHombre['total_seleccionado'];

    $consultaSeleccionadaOtro = "SELECT COUNT(*) AS total_seleccionado FROM egresados WHERE genero = 'otro'";
    if (!empty($estadoCivil)) {
        $consultaSeleccionadaOtro .= " AND ecivil = '$estadoCivil'";
    }
    $resultadoSeleccionadoOtro = mysqli_query($conexion, $consultaSeleccionadaOtro);
    $rowSeleccionadoOtro = mysqli_fetch_assoc($resultadoSeleccionadoOtro);
    $totalSeleccionadoOtro = $rowSeleccionadoOtro['total_seleccionado'];

    $porcentajeMujer = ($totalSeleccionadoMujer / $totalRegistros) * 100;
    $porcentajeFormateado_M = number_format($porcentajeMujer);

    $porcentajeHombre = ($totalSeleccionadoHombre / $totalRegistros) * 100;
    $porcentajeFormateado_H = number_format($porcentajeHombre);

    $porcentajeOtro = ($totalSeleccionadoOtro / $totalRegistros) * 100;
    $porcentajeFormateado_O = number_format($porcentajeOtro);
}

$porcentaje = ($totalSeleccionado / $totalRegistros) * 100;
$porcentajeFormateado = number_format($porcentaje);

$consultaGenero = "SELECT COUNT(*) AS total_genero FROM egresados WHERE genero = '$genero'";
$resultadoGenero = mysqli_query($conexion, $consultaGenero);
$rowGenero = mysqli_fetch_assoc($resultadoGenero);
$totalGenero = $rowGenero['total_genero'];

mysqli_close($conexion);

$mostrar = true;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generador de Gráficos</title>
    <style>
        body {
            text-align: center;
        }
        .textos {
            text-align: unset !important;
            text-align: initial;
            position: absolute;
            display: inline-block;
            margin-left: -688px;
            margin-top: 47px;
            font-weight: bold;
        }
        .texto {
            text-align: unset !important;
            text-align: initial;
            position: absolute;
            display: inline-block;
            margin-left: -319px;
            margin-top: 116px;
            font-weight: bold;
        }
        #graficas {
            margin: auto;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Generador de Gráficos</h1>
    <form method="POST" action="">
        <label for="genero">Género:</label>
        <select name="genero" id="genero">
            <option value="todos">Todos</option>
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
            <option value="otro">Otro</option>
        </select>

        <label for="ecivil">Estado Civil:</label>
        <select id="ecivil" name="ecivil">
            <option value="">--Elije una opción--</option>
            <option value="soltero">Solteros</option>
            <option value="casado">Casados</option>
            <option value="divorciado">Divorciados</option>
            <option value="viudo">Viudos</option>
        </select>
        <button type="submit">Generar Gráfico</button>
        <button onclick="window.print()">Imprimir</button>
    </form>
    <?php
    if ($mostrar == true) {
        if ($genero == "todos") {
            echo '<div class="textos">';
            echo '<p>Total de registros: ' . $totalRegistros . '</p>';
            echo '<p>Total seleccionado Mujer: ' . $totalSeleccionadoMujer . '</p>';
            echo '<p>Porcentaje seleccionado Mujer: ' . $porcentajeFormateado_M . '%</p>';
            echo '<p>Total seleccionado Hombre: ' . $totalSeleccionadoHombre . '</p>';
            echo '<p>Porcentaje seleccionado Hombre: ' . $porcentajeFormateado_H . '%</p>';
            echo '<p>Total seleccionado Otro: ' . $totalSeleccionadoOtro . '</p>';
            echo '<p>Porcentaje seleccionado Otro: ' . $porcentajeFormateado_O . '%</p>';
            echo '<p>Estado civil: '. $estadoCivil . '</p>';
            echo '</div>';

            echo '<div>';
            echo '<div id="graficas" style="width: 200px; height: 400px; position: relative; display: inline-block; margin-right: 20px; border: 2px solid black;">';
            echo '<div id="graficas" style="background-color: pink; height: ' . $porcentajeMujer . '%; width: 100%; position: absolute; bottom: 0;"></div>';
            echo '</div>';

            echo '<div id="graficas" style="width: 200px; height: 400px; position: relative; display: inline-block; margin-right: 20px; border: 2px solid black;">';
            echo '<div id="graficas" style="background-color: #2196F3; height: ' . $porcentajeHombre . '%; width: 100%; position: absolute; bottom: 0;"></div>';
            echo '</div>';

            echo '<div id="graficas" style="width: 200px; height: 400px; position: relative; display: inline-block; border: 2px solid black;">';
            echo '<div id="graficas" style="background-color: #FFC107; height: ' . $porcentajeOtro . '%; width: 100%; position: absolute; bottom: 0;"></div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="texto">';
            echo '<p>Total de registros: ' . $totalRegistros . '</p>';
            echo '<p>Total seleccionado: ' . $totalSeleccionado . '</p>';
            echo '<p>Porcentaje seleccionado: ' . $porcentajeFormateado . '%</p>';
            echo '<p>Estado civil: '. $estadoCivil . '</p>';
            echo '</div>';

            echo '<div id="graficas" style="width: 200px; height: 400px; position: relative; display: inline-block; border: 2px solid black;">';
            echo '<div id="graficas" style="background-color: ' . ($genero === 'hombre' ? '#2196F3' : ($genero === 'mujer' ? 'pink' : 'green')) . '; height: ' . $porcentaje . '%; width: 100%; position: absolute; bottom: 0;"></div>';
            echo '</div>';
        }
    }
    ?>
</body>
</html>
