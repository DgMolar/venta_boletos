DELIMITER //
CREATE PROCEDURE obtenerInformacionVentas(IN fechaInicioParam DATE, IN fechaFinParam DATE, IN orderParam VARCHAR(20))
BEGIN
    SET @query = CONCAT('
    SELECT v.id_venta, b.id_boleto, b.id_viaje, b.numero_asiento, v.total, mp.nombre_metodo, e.correo_empleado, v.fecha_venta
    FROM ventas v
    INNER JOIN boletos b ON v.id_venta = b.id_venta
    INNER JOIN metodospago mp ON v.id_metodo_pago = mp.id_metodo_pago
    INNER JOIN empleados e ON v.id_empleado = e.id_empleado
    WHERE v.fecha_venta BETWEEN ? AND ?');

    IF orderParam = 'id_boleto' THEN
        SET @query = CONCAT(@query, ' ORDER BY b.id_boleto');
    ELSEIF orderParam = 'correo_empleado' THEN
        SET @query = CONCAT(@query, ' ORDER BY e.correo_empleado');
    ELSE
        SET @query = CONCAT(@query, ' ORDER BY v.id_venta');
    END IF;

    PREPARE stmt FROM @query;
    SET @fechaInicioParam = fechaInicioParam;
    SET @fechaFinParam = fechaFinParam;
    EXECUTE stmt USING @fechaInicioParam, @fechaFinParam;
    DEALLOCATE PREPARE stmt;
END //
DELIMITER ;
