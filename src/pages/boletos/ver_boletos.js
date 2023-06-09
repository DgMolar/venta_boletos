import { imprimirBoletos } from "./ver_boletos_components.js";
$.ajax({
  url: "./boletos/ver_boletos.php",
  type: "GET",
  dataType: "json",
  success: function (data) {
    // Accede a los resultados dentro del objeto JSON
    var resultados = data.resultados;

    // Itera sobre los datos y haz algo con ellos
    resultados.forEach(function (row) {
      var filaHTML = imprimirBoletos(row);
      // Agregar la fila a la tabla o cualquier otro elemento en tu página
      // Por ejemplo:
      $("#tablaResultados").append(filaHTML);
    });
  },
  error: function (xhr, status, error) {
    console.error(error);
  },
});
