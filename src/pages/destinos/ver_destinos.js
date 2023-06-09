import { imprimirDestinos } from "./ver_destinos_components.js";
$.ajax({
  url: "./destinos/ver_destinos.php",
  type: "GET",
  dataType: "json",
  success: function (data) {
    // Accede a los resultados dentro del objeto JSON
    var resultados = data.resultados;
    console.log(resultados);

    // Itera sobre los datos y haz algo con ellos
    resultados.forEach(function (row) {
      var filaHTML = imprimirDestinos(row);
      // Agregar la fila a la tabla o cualquier otro elemento en tu página
      // Por ejemplo:
      $("#tablaResultados").append(filaHTML);
      $(document).ready(function () {
        $("#btnMostrarFormulario").click(function () {
          $("#formularioContainer").show();
        });
      });
    });
  },
  error: function (xhr, status, error) {
    console.error(error);
  },
});
