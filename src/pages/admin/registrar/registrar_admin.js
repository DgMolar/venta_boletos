// Obtener el formulario de registro
const formRegister = document.getElementById("register-form");
// Obtener los campos de entrada
const nombreAdministradorInput = document.getElementById(
  "nombre-administrador"
);
const apellidoAdministradorInput = document.getElementById(
  "apellido-administrador"
);
const emailInput = document.getElementById("email-register");
const passwordInput = document.getElementById("password-first");
const confirmInput = document.getElementById("password-confirm");

// Escuchar el evento submit del formulario
formRegister.addEventListener("submit", (event) => {
  event.preventDefault(); // Evitar el envío del formulario por defecto

  // Limpiar los errores anteriores
  clearErrors();

  // Obtener los valores de los campos de entrada
  const nombreAdministrador = nombreAdministradorInput.value;
  const apellidoAdministrador = apellidoAdministradorInput.value;
  const email = emailInput.value;
  const password = passwordInput.value;
  const confirm = confirmInput.value;

  // Validar los campos de entrada
  if (
    nombreAdministrador === "" ||
    apellidoAdministrador === "" ||
    email === "" ||
    password === "" ||
    confirm === ""
  ) {
    // Mostrar errores si los campos están vacíos
    showErrors("Ingrese todos los campos.");
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
