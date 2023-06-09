function imprimirBoletos({
  id_boleto,
  id_viaje,
  nombre,
  apellido,
  destino,
  numero_asiento,
  nombre_empleado,
}) {
  return `
      <tr>
        <td>${id_boleto}</td>
        <td>${id_viaje}</td>
        <td>${nombre}</td>
        <td>${apellido}</td>
        <td>${destino}</td>
        <td>${numero_asiento}</td>
        <td>${nombre_empleado}</td>
        <td>
          <button class='btn btn-success' onclick="location.href='./imprimir_boleto.php?idViaje=${id_viaje}&asientoSeleccionado=${numero_asiento}'">
            Ver boleto
          </button>
        </td>
      </tr>
    `;
}

export { imprimirBoletos };
