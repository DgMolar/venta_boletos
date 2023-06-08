import { imprimirDestinos } from "./buscar_destinos_components.js";
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
      console.log(viajes);
      //mostrar los resultados en el HTML
      // Obtener el elemento HTML donde se mostrará la tabla
      var tablaViajesDestinos = document.getElementById("resultados-body");
      //eliminar lo que hay en tablaViajesDestinos.
      tablaViajesDestinos.innerHTML = "";

      if (viajes.length > 0) {
        viajes.forEach((viaje) => {
          const destinosList = document.createElement("tr");
          // destinosList.classList.add("col-md-3");
          destinosList.innerHTML = imprimirDestinos(viaje);
          tablaViajesDestinos.append(destinosList);
        });
      } else {
        tablaViajesDestinos.innerHTML =
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
