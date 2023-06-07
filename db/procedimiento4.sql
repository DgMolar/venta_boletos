DELIMITER //

CREATE PROCEDURE ObtenerAsientosOcupados(IN idViaje INT)
BEGIN
    SELECT b.id_viaje, b.numero_asiento
    FROM viajes v
    INNER JOIN boletos b ON b.id_viaje = v.id_viaje
    WHERE v.id_viaje = idViaje
    GROUP BY b.numero_asiento;
END //

DELIMITER ;
