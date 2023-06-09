function imprimirAutobuses({
  id_autobus,
  placa,
  modelo,
  estado,
  capacidad_asientos,
}) {
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
        </td>
      </tr>
    `;
}

export { imprimirAutobuses };
