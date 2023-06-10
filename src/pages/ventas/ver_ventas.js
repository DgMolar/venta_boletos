import { imprimirVentas } from "./ver_ventas_components.js";

// Capturar el evento de envío del formulario
$("#filtroForm").submit(function (event) {
  event.preventDefault(); // Evitar que el formulario se envíe por defecto

  // Obtener los valores seleccionados del formulario
  var fechaInicio = $("#fechaInicio").val();
  var fechaFin = $("#fechaFin").val();
  var ordenamiento = $("#ordenamiento").val();

  // Realizar la llamada AJAX con los parámetros seleccionados
  $.ajax({
    url: "./ventas/ver_ventas.php",
    type: "GET",
    dataType: "json",
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin,
      ordenamiento: ordenamiento,
    },
    success: function (data) {
      // Limpiar la tabla de resultados
      $("#tablaResultados").empty();

      // Acceder a los resultados dentro del objeto JSON
      var resultados = data.resultados;
      console.log(resultados);

      // Iterar sobre los datos y agregarlos a la tabla
      resultados.forEach(function (row) {
        var filaHTML = imprimirVentas(row);
        $("#tablaResultados").append(filaHTML);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
});
