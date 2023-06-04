DELIMITER //

CREATE PROCEDURE BuscarViajePorDestino(palabra_ciudad VARCHAR(50))
BEGIN
    SELECT V.id_viaje, V.id_destino, D.nombre, D.direccion, D.ciudad, V.fecha_salida, V.fecha_llegada, V.costo, A.id_autobus, A.placa, A.modelo, A.estado, A.capacidad_asientos
    FROM Viajes V
    INNER JOIN Destinos D ON V.id_destino = D.id_destino
    INNER JOIN Autobuses A ON V.id_autobus = A.id_autobus
    WHERE D.ciudad LIKE CONCAT('%', palabra_ciudad, '%');
END //

DELIMITER ;
