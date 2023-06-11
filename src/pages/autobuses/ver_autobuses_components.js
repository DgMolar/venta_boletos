function imprimirAutobuses({
  id_autobus,
  placa,
  modelo,
  estado,
  capacidad_asientos,
}) {
  let buttonHTML = "";

  if (estado === "disponible") {
    buttonHTML = `
      <button class='btn btn-danger' onclick="location.href='./autobuses/eliminar_autobus.php?idAutobus=${id_autobus}'">
        Eliminar
      </button>
    `;
  } else {
    buttonHTML = `
      <button class='btn btn-danger' disabled>
        Eliminar
      </button>
    `;
  }

  return `
    <tr>
      <td>${id_autobus}</td>
      <td>${placa}</td>
      <td>${modelo}</td>
      <td>${estado}</td>
      <td>${capacidad_asientos}</td>
      <td>
        <button class='btn btn-warning' onclick="location.href='./modificar_autobus.php?idAutobus=${id_autobus}'">
          Modificar
        </button>
        ${buttonHTML}
      </td>
    </tr>
  `;
}

export { imprimirAutobuses };
