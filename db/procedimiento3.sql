DELIMITER //

CREATE PROCEDURE ObtenerVentasPorFecha(fecha_venta DATE)
BEGIN
    SELECT *
    FROM Ventas
    WHERE DATE(fecha_venta) = fecha_venta;
END //

DELIMITER ;
