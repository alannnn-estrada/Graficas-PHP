<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perfilegreso";

// Realiza la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtiene la matrícula ingresada en el formulario
$matricula = $_POST['matricula'];

// Ejecuta la consulta utilizando la matrícula
$sql = "SELECT respuesta, COUNT(*) as cantidad FROM respuestas WHERE matricula = '$matricula' GROUP BY respuesta";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row["respuesta"]] = $row["cantidad"];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gráfico Circular</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <canvas id="myChart"></canvas>
  <script>
    // Obtiene los datos de PHP
    var data = <?php echo json_encode($data); ?>;

    // Crea el gráfico circular utilizando Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: Object.keys(data),
        datasets: [{
          data: Object.values(data),
          backgroundColor: [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)'
          ]
        }]
      }
    });
  </script>
</body>
</html>
