function imprimirViajes({
  id_viaje,
  nombre,
  ciudad,
  fecha_salida,
  estado_viaje,
  costo,
  placa,
  capacidad_asientos,
}) {
  return `
      <tr>
        <td>${id_viaje}</td>
        <td>${nombre}</td>
        <td>${ciudad}</td>
        <td>${fecha_salida}</td>
        <td>${estado_viaje}</td>
        <td>${costo}</td>
        <td>${placa}</td>
        <td>${capacidad_asientos}</td>
        <td>
          <button class='btn btn-warning' onclick="location.href='./imprimir_boleto.php?idViaje=${id_viaje}'">
            Modificar
          </button>
        </td>
      </tr>
    `;
}

export { imprimirViajes };
