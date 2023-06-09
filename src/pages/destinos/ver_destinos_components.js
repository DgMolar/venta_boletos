function imprimirDestinos({ id_destino, nombre, direccion, ciudad }) {
  return `
      <tr>
        <td>${id_destino}</td>
        <td>${nombre}</td>
        <td>${direccion}</td>
        <td>${ciudad}</td>
        <td>
          <button class='btn btn-warning' onclick="location.href='./imprimir_boleto.php?idViaje=${id_destino}'">
            Modificar
          </button>
        </td>
      </tr>
    `;
}

export { imprimirDestinos };
