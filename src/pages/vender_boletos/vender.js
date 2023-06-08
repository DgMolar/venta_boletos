verFormulario();
function verFormulario() {
  //obtener query strings de la url actual
  const queryParams = new URLSearchParams(window.location.search);
  const idViaje = parseInt(queryParams.get("idViaje"));
  const capacidad = parseInt(queryParams.get("capacidad"));
  const precio = queryParams.get("precio");
  //rellenar los campos del formulario con los valores de la url
  const inputIdViaje = document.getElementById("input-id-viaje");
  inputIdViaje.value = idViaje;
  // Obtener el elemento span donde se mostrará el valor
  const inputTotal = document.getElementById("valor-total");
  // Establecer el valor en el elemento input
  inputTotal.value = precio;

  console.log("El viaje es:", parseInt(idViaje));
  // Crear objeto XMLHttpRequest
  var xhr = new XMLHttpRequest();
  // Configurar la solicitud
  xhr.open("POST", "./vender_boletos/asientos.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  // Definir la función de respuesta
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Obtener la respuesta en formato JSON
      var response = JSON.parse(xhr.responseText);

      // Obtener los valores de la respuesta
      let totalAsientos = response.totalAsientos;
      let asientosOcupados = response.asientosOcupados;
      // Comprobar si las variables son nulas
      if (totalAsientos === "" || asientosOcupados === "") {
        //dar valores por defecto del viaje seleccionado en caso de que no se obtengan los valores
        totalAsientos = capacidad;
        // console.log("Total de asientos por parametros: ", totalAsientos);
        // console.log(
        //   "¡Advertencia! Los valores de totalAsientos o asientosOcupados son nulos."
        // );
        // return; // Detener el script
      }

      // Utilizar los valores en tu código
      console.log("Total de asientos: ", totalAsientos);
      console.log("Asientos ocupados: ", asientosOcupados);
      // Crear un array para almacenar los números de asiento ocupados
      const numerosAsientosOcupados = [];

      // Obtener los números de asiento del objeto asientosOcupados
      for (const asiento of asientosOcupados) {
        const numeroAsiento = parseInt(asiento.numero_asiento, 10);
        numerosAsientosOcupados.push(numeroAsiento);
      }

      // Imprimir los números de asiento ocupados en la consola
      console.log("Números de asiento ocupados: ", numerosAsientosOcupados);
      generarBotonesAsientos(totalAsientos, numerosAsientosOcupados);
      // Generar el cambio.
      generarCambio();
      validarFormulario();
    }
  };

  // Enviar la solicitud con el parámetro idViaje
  xhr.send(JSON.stringify({ idViaje: idViaje }));
}

// Generar asientos.
// Función para generar los botones de asientos en una tabla
function generarBotonesAsientos(totalAsientos, numerosAsientosOcupados) {
  const listaAsientosDiv = document.getElementById("lista-asientos");
  listaAsientosDiv.innerHTML = ""; // Limpiar el contenido anterior

  const filasPorTabla = Math.ceil(totalAsientos / 4);

  // Generar la tabla de asientos
  const tablaAsientos = document.createElement("table");
  tablaAsientos.classList.add(
    "table",
    "table-bordered",
    "text-center",
    "small"
  );

  for (let i = 0; i < filasPorTabla; i++) {
    const fila = document.createElement("tr");

    for (let j = 0; j < 4; j++) {
      const numeroAsiento = i * 4 + j + 1;

      if (numeroAsiento > totalAsientos) break;

      const celda = document.createElement("td");
      const botonAsiento = document.createElement("button");
      botonAsiento.type = "button";
      botonAsiento.classList.add("btn", "btn-primary");
      botonAsiento.textContent = numeroAsiento;

      // Verificar si el asiento está ocupado
      if (numerosAsientosOcupados.includes(numeroAsiento)) {
        botonAsiento.disabled = true;
        botonAsiento.classList.replace("btn-primary", "btn-secondary");
      } else {
        botonAsiento.addEventListener("click", function () {
          // Imprimir el número del asiento seleccionado en la consola
          console.log("Asiento seleccionado: " + numeroAsiento);
          //insertar valor en input de formulario.
          const inputAsiento = document.getElementById("asiento-seleccionado");
          inputAsiento.value = numeroAsiento;
        });
      }

      celda.appendChild(botonAsiento);
      fila.appendChild(celda);
    }

    tablaAsientos.appendChild(fila);
  }

  listaAsientosDiv.appendChild(tablaAsientos);
}
//Generar cambio
function generarCambio() {
  const cantidadPagoInput = document.getElementById("cantidad-pago");
  const cambioPagoInput = document.getElementById("cambio-pago");

  // Agregar un evento de escucha para el cambio en el campo "cantidad-pago"
  cantidadPagoInput.addEventListener("input", function () {
    const totalPagar = parseFloat(document.getElementById("valor-total").value);
    const cantidadPago = parseFloat(cantidadPagoInput.value);

    // Calcular el cambio
    const cambio = cantidadPago - totalPagar;

    // Actualizar el campo "cambio-pago" con el valor calculado
    cambioPagoInput.value = cambio.toFixed(2); // Limitar el número de decimales a 2
  });
}
// Función para validar el formulario
function validarFormulario() {
  // Obtener el formulario
  const formulario = document.getElementById("formulario-completo-form");

  // Agregar un evento de escucha para el envío del formulario
  formulario.addEventListener("submit", function (e) {
    e.preventDefault(); // Evitar el envío del formulario

    // Obtener los valores de los campos del formulario
    const idViaje = document.getElementById("input-id-viaje").value;
    const idEmpleado = document.getElementById("id-empleado").value;
    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const correo = document.getElementById("correo").value;
    const telefono = document.getElementById("telefono").value;
    const asientoSeleccionado = document.getElementById(
      "asiento-seleccionado"
    ).value;
    const metodoPago = document.getElementById("metodo-pago").value;
    const totalPagar = document.getElementById("valor-total").value;
    const cantidadPago = document.getElementById("cantidad-pago").value;

    // Construir el mensaje de alerta con los datos del formulario
    const mensaje = `
    ID del Viaje: ${idViaje}
    ID del Empleado: ${idEmpleado}
    Nombre: ${nombre}
    Apellido: ${apellido}
    Correo: ${correo}
    Teléfono: ${telefono}
    Asiento seleccionado: ${asientoSeleccionado}
    Método de Pago: ${metodoPago}
    Total a Pagar: ${totalPagar}
    Cantidad Pagada: ${cantidadPago}
  `;

    // Mostrar el mensaje de alerta con los datos del formulario
    alert(mensaje);
    // Enviar el formulario
    formulario.submit();
  });
}
//exportar la funcion
export { verFormulario };
