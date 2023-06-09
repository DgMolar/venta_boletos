function imprimirDestinos({ id_destino, nombre, direccion, ciudad }) {
  return `
      <tr>
        <td>${id_destino}</td>
        <td>${nombre}</td>
        <td>${direccion}</td>
        <td>${ciudad}</td>
        <td>
          <button class='btn btn-warning' onclick="location.href='./modificar_destino.php?idDestino=${id_destino}'">
            Modificar
          </button>
        </td>
      </tr>
    `;
}

export { imprimirDestinos };
