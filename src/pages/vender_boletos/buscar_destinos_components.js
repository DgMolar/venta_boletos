function imprimirDestinos({
  id_viaje,
  nombre,
  direccion,
  ciudad,
  fecha_salida,
  costo,
  capacidad_asientos,
}) {
  return `
    
    <td>${id_viaje}</td>
    <td>${nombre}</td>
    <td>${direccion}</td>
    <td>${ciudad}</td>
    <td>${fecha_salida}</td>
    <td>${costo}</td>
    <td>${capacidad_asientos}</td>
    <td><button id="destino-seleccionado" class='select-destinoBtn btn btn-success' onclick="location.href='./vender.php?idViaje=${id_viaje}&capacidad=${capacidad_asientos}&precio=${costo}'" value='${id_viaje}'><i class='bi bi-check2-square'></i></button></td>
    
    `;
}
export { imprimirDestinos };
