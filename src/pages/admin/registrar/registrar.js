// Obtener el formulario de registro
const formRegister = document.getElementById("register-form");
// Obtener los campos de entrada
const nombreEmpleadoInput = document.getElementById("nombre-empleado");
const apellidoEmpleadoInput = document.getElementById("apellido-empleado");
const emailInput = document.getElementById("email-register");
const passwordInput = document.getElementById("password-first");
const confirmInput = document.getElementById("password-confirm");
const puestoInput = document.getElementById("puesto");

// Escuchar el evento submit del formulario
formRegister.addEventListener("submit", (event) => {
  event.preventDefault(); // Evitar el envío del formulario por defecto

  // Limpiar los errores anteriores
  clearErrors();

  // Obtener los valores de los campos de entrada
  const nombreEmpleado = nombreEmpleadoInput.value;
  const apellidoEmpleado = apellidoEmpleadoInput.value;
  const email = emailInput.value;
  const password = passwordInput.value;
  const confirm = confirmInput.value;
  const puesto = puestoInput.value;

  // Validar los campos de entrada
  if (
    nombreEmpleado === "" &&
    apellidoEmpleado === "" &&
    email === "" &&
    password === "" &&
    confirm === "" &&
    puesto === ""
  ) {
    // Mostrar errores si los campos están vacíos
    showErrors("Ingrese todos los campos.");
  } else if (nombreEmpleado === "") {
    // Mostrar errores si el campo de nombre de empleado está vacío
    showErrors("Ingrese el nombre de empleado.");
  } else if (apellidoEmpleado === "") {
    // Mostrar errores si el campo de apellido de empleado está vacío
    showErrors("Ingrese el apellido de empleado.");
  } else if (email === "") {
    // Mostrar errores si el campo de correo electrónico está vacío
    showErrors("Ingrese el correo electrónico.");
  } else if (password === "") {
    // Mostrar errores si el campo de contraseña está vacío
    showErrors("Ingrese la contraseña.");
  } else if (confirm === "") {
    // Mostrar errores si el campo de confirmación de contraseña está vacío
    showErrors("Confirme la contraseña.");
  } else if (puesto === "") {
    // Mostrar errores si no se ha seleccionado un puesto
    showErrors("Seleccione un puesto.");
  } else if (password !== confirm) {
    // Mostrar errores si las contraseñas no coinciden
    showErrors("Las contraseñas no coinciden.");
  } else {
    // Enviar el formulario si los campos son válidos
    // Mostrar mensaje de éxito.
    alert("Registro exitoso.");

    // Aquí puedes agregar código adicional si deseas realizar alguna acción después de enviar el formulario

    formRegister.submit();
  }
});

// Función para mostrar errores
function showErrors(errorMessage) {
  const validationErrors = document.getElementById("validationErrors");
  const errorText = document.createElement("p");
  errorText.textContent = errorMessage;
  validationErrors.appendChild(errorText);
}

// Función para limpiar los errores anteriores
function clearErrors() {
  const validationErrors = document.getElementById("validationErrors");
  validationErrors.innerHTML = "";
}
