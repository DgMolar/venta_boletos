// Utiliza fetch para obtener el contenido del archivo del navbar
fetch("../components/navbar/navbar.html")
  .then((response) => response.text()) // convierte la respuesta a texto
  .then((data) => {
    console.log("Cargando el navbar...");
    // Coloca el contenido del navbar en el contenedor del navbar
    document.getElementById("navbar-container").innerHTML = data;
  })
  .catch((error) => {
    console.error("Error al cargar el navbar:", error);
  });
