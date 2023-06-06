document.getElementById("login-form").addEventListener("submit", (event) => {
  event.preventDefault(); // Evita el envío del formulario por defecto

  const formLogin = document.getElementById("login-form");
  var correo = document.getElementById("email-login").value;
  var password = document.getElementById("password-login").value;

  var emailLogin = document.getElementById("email-login");
  var passwordLogin = document.getElementById("password-login");

  var errorContainer = document.getElementById("validationErrors");
  errorContainer.innerHTML = ""; // Limpiar los errores anteriores

  if (correo === "" && password === "") {
    emailLogin.classList.add("is-invalid");
    passwordLogin.classList.add("is-invalid");
    errorContainer.innerHTML =
      "<p class='text-danger'>Ingrese el correo electrónico y la contraseña.</p>";
  } else if (correo === "") {
    emailLogin.classList.add("is-invalid");
    passwordLogin.classList.remove("is-invalid");
    errorContainer.innerHTML =
      "<p class='text-danger'>Ingrese el correo electrónico.</p>";
  } else if (password === "") {
    emailLogin.classList.remove("is-invalid");
    passwordLogin.classList.add("is-invalid");
    errorContainer.innerHTML =
      "<p class='text-danger'>Ingrese la contraseña.</p>";
  } else {
    // Si los campos son válidos, enviar el formulario
    formLogin.submit();
  }
});

//recibir parametros de la url solo si existe.
// Obtener el mensaje de la URL
const params = new URLSearchParams(window.location.search);
const mensaje = params.get("mensaje");

// Mostrar el mensaje en la página
if (mensaje) {
  const errorContainer = document.getElementById("validationErrors");
  errorContainer.innerHTML = "<p class='text-danger'>" + mensaje + "</p>";
}
