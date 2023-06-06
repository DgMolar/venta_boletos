function verFormulario() {
  console.log("entre a la funcion");
  const viajeBtn = document.getElementById("select-viaje-Btn");
  viajeBtn.addEventListener("click", async () => {
    console.log("entre al evento");
    //añadir clase para que se vea el formulario
    const estadoForm = document.getElementById("formulario-completo");
    // Mostrar el formulario completo quitando la clase "d-none"
    estadoForm.classList.remove("d-none");
  });
}

export { verFormulario };
