// Obtener los datos de la base de datos
function obtenerDatos() {
  fetch('./obtener_datos.php')
    .then(response => response.json())
    .then(data => {
      // Procesar los datos recibidos
      const carreras = data.map(d => d.carrera);
      const cantidadEgresados = data.map(d => d.cantidad);

      // Generar el gráfico
      var ctx = document.getElementById('grafico').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: carreras,
          datasets: [{
            label: 'Cantidad de Egresados',
            data: cantidadEgresados,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }
          }
        }
      });
    })
    .catch(error => {
      console.error('Error al obtener los datos:', error);
    });
}

// Actualizar las gráficas cada 5 segundos
setInterval(obtenerDatos, 5000);

// Llamar a la función obtenerDatos() al cargar la página
window.addEventListener('load', obtenerDatos);

