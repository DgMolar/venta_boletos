DELIMITER //

CREATE FUNCTION CalcularTotalVentas(
  fecha_inicio DATE,
  fecha_fin DATE
) RETURNS DECIMAL(10, 2)
BEGIN
    DECLARE total_ventas DECIMAL(10, 2);

    SELECT SUM(total) INTO total_ventas
    FROM venta_boletos.ventas
    WHERE fecha_venta >= fecha_inicio AND fecha_venta <= fecha_fin
    ORDER BY total DESC;

    RETURN total_ventas;
END //

DELIMITER ;

