function imprimirVentas({
  id_venta,
  id_boleto,
  total,
  nombre_metodo,
  correo_empleado,
  fecha_venta,
  id_viaje,
  numero_asiento,
}) {
  return `
    <tr>
      <td>${id_venta}</td>
      <td>${id_boleto}</td>
      <td>${total}</td>
      <td>${nombre_metodo}</td>
      <td>${correo_empleado}</td>
      <td>${fecha_venta}</td>
      <td>
        <button class='btn btn-success' onclick="location.href='./imprimir_boleto.php?idViaje=${id_viaje}&asientoSeleccionado=${numero_asiento}'">
          Ver boleto
        </button>
      </td>
    </tr>
  `;
}

export { imprimirVentas };
