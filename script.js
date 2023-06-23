$(document).ready(function() {
    // Función para obtener las opciones seleccionadas del formulario
    function obtenerOpciones() {
        var genero = $("#genero").val();
        var ecivil = $("#ecivil").val();
        var carrera = $("#carrera").val();
        var especialidad = $("#especialidad").val();

        return {
            genero: genero,
            ecivil: ecivil,
            carrera: carrera,
            especialidad: especialidad
        };
    }

    // Función para hacer la solicitud AJAX y actualizar el gráfico
    function actualizarGrafico(valores, colores) {
        var ctx = document.getElementById("grafico").getContext("2d");

        // Obtener las opciones seleccionadas
        var opciones = obtenerOpciones();

        // Actualizar las etiquetas y datos del gráfico según las opciones seleccionadas
        var genero = opciones.genero;
        var etiquetas = [];
        var datos = [];

        if (genero === "") {
            // Si no se selecciona un género específico, mostrar etiquetas "Hombres" y "Mujeres" con sus respectivos valores
            etiquetas = ["Hombres", "Mujeres"];
            datos = valores;
        } else if (genero === "hombre") {
            // Mostrar etiqueta "Hombres" con su respectivo valor
            etiquetas = ["Hombres"];
            datos = [valores[0]];
        } else if (genero === "mujer") {
            // Mostrar etiqueta "Mujeres" con su respectivo valor
            etiquetas = ["Mujeres"];
            datos = [valores[1]];
        } else if (genero === "todos") {
            // Mostrar etiquetas "Hombres" y "Mujeres" con sus respectivos valores
            etiquetas = ["Hombres", "Mujeres"];
            datos = valores;
        }

        // Actualizar el gráfico con los nuevos datos y etiquetas
        var chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: etiquetas,
                datasets: [{
                    data: datos,
                    backgroundColor: colores
                }]
            },
            options: {
                legend: {
                    display: true
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            callback: function(value) {
                                if (value >= 1000) {
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                } else {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    }

    // Función para actualizar el gráfico con los nuevos datos
    function actualizarGraficoEnBaseALasOpciones() {
        // Obtener las opciones seleccionadas
        var opciones = obtenerOpciones();

        // Hacer la solicitud AJAX a consulta.php con las opciones seleccionadas
        $.ajax({
            url: "consulta.php",
            type: "POST",
            data: opciones,
            success: function(response) {
                // Obtener los datos necesarios para el gráfico
                var valores = response.valores;
                var colores = response.colores;

                // Actualizar el gráfico con los nuevos datos
                actualizarGrafico(valores, colores);
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
            }
        });
    }

    // Manejar el evento de envío del formulario
    $("#opciones-form").submit(function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado de envío del formulario

        // Actualizar el gráfico con las opciones seleccionadas
        actualizarGraficoEnBaseALasOpciones();
    });
    
    function limpiarResultados() {
    $("#genero").val("");
    $("#ecivil").val("");
    $("#carrera").val("");
    $("#especialidad").val("");

    // Limpiar el gráfico
    var ctx = document.getElementById("grafico").getContext("2d");
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    // Refrescar la página
    location.reload();
}


    // Función para exportar a PDF
    function exportarAPDF() {
        // Obtener las opciones seleccionadas
        var opciones = obtenerOpciones();

        // Hacer la solicitud AJAX a consulta.php con las opciones seleccionadas
        $.ajax({
            url: "consulta.php",
            type: "POST",
            data: opciones,
            success: function(response) {
                // Obtener los datos necesarios para el gráfico
                var valores = response.valores;
                var colores = response.colores;

                // Crear un nuevo documento PDF
                var doc = new jsPDF();

                // Agregar el gráfico al documento PDF
                var canvas = document.getElementById("grafico");
                var imgData = canvas.toDataURL("image/png");
                doc.addImage(imgData, "PNG", 10, 10, 180, 100);

                // Agregar los valores seleccionados al documento PDF
                doc.setFontSize(12);
                doc.text("Opciones seleccionadas:", 10, 120);
                doc.text("Género: " + opciones.genero, 10, 130);
                doc.text("Estado Civil: " + opciones.ecivil, 10, 140);
                doc.text("Carrera: " + opciones.carrera, 10, 150);
                doc.text("Especialidad: " + opciones.especialidad, 10, 160);

                // Guardar el documento PDF
                doc.save("resultado.pdf");
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX: " + error);
            }
        });
    }

    // Manejar el evento de clic del botón "Limpiar resultados"
    $("#limpiar-btn").click(function() {
        limpiarResultados();
    });


    // Manejar el evento de clic del botón "Exportar a PDF"
    $("#exportar-btn").click(function() {
        exportarAPDF();
    });
});

