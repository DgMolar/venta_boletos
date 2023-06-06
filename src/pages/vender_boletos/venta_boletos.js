import { verFormulario } from "./vender.js";
// Función para hacer la solicitud AJAX y mostrar los resultados en la tabla
function buscarViajes(event) {
  event.preventDefault(); // Evitar la recarga de la página

  // Obtener el valor del campo de entrada
  var destino = document.getElementById("destino").value;
  // Validar que se haya ingresado un destino
  if (destino.trim() === "") {
    alert("Por favor, ingrese un destino");
    return; // Detener la ejecución de la función si no hay destino
  }
  // Crear un objeto XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Configurar la solicitud
  xhr.open(
    "GET",
    "./vender_boletos/buscar_destinos.php?destino=" +
      encodeURIComponent(destino),
    true
  );

  // Configurar el callback de la respuesta
  xhr.onload = function () {
    if (xhr.status === 200) {
      // La solicitud fue exitosa
      var viajes = JSON.parse(xhr.responseText);

      // Obtener el elemento HTML donde se mostrará la tabla
      var tablaViajes = document.getElementById("tabla-viajes");

      // Limpiar el contenido anterior
      tablaViajes.innerHTML = "";

      if (viajes.length > 0) {
        // Crear el encabezado de la tabla
        var encabezadoHTML =
          "<tr>" +
          "<th>ID Viaje</th>" +
          "<th>Nombre</th>" +
          "<th>Dirección</th>" +
          "<th>Ciudad</th>" +
          "<th>Fecha Salida</th>" +
          "<th>Costo</th>" +
          "<th>Capacidad Asientos</th>" +
          "<th>Acción</th>" +
          "</tr>";
        tablaViajes.innerHTML += encabezadoHTML;

        // Crear las filas de la tabla con los datos de cada viaje
        for (var i = 0; i < viajes.length; i++) {
          var viaje = viajes[i];
          var filaHTML =
            "<tr>" +
            "<td>" +
            viaje.id_viaje +
            "</td>" +
            "<td>" +
            viaje.nombre +
            "</td>" +
            "<td>" +
            viaje.direccion +
            "</td>" +
            "<td>" +
            viaje.ciudad +
            "</td>" +
            "<td>" +
            viaje.fecha_salida +
            "</td>" +
            "<td>" +
            viaje.costo +
            "</td>" +
            "<td>" +
            viaje.capacidad_asientos +
            "</td>" +
            "<td>" +
            "<button id='select-viaje-Btn' class='btn btn-success' ><i class='bi bi-check2-square'></i></button>" +
            "</td>" +
            "</tr>";
          tablaViajes.innerHTML += filaHTML;
          console.log("termine de imp");
          verFormulario();
        }
      } else {
        tablaViajes.innerHTML =
          "<tr><td colspan='8' class='alert alert-danger'>No se encontraron viajes para el destino especificado.</td></tr>";
      }
    } else {
      // Hubo un error en la solicitud
      console.error("Error en la solicitud. Estado:", xhr.status);
    }
  };
  // Enviar la solicitud
  xhr.send();
}

// Obtener el formulario y adjuntar el evento de envío
var buscarViajesForm = document.getElementById("buscar-viajes-form");
buscarViajesForm.addEventListener("submit", buscarViajes);
