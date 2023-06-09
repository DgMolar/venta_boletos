DELIMITER $$
CREATE TRIGGER EstadoAutobusDelete
AFTER DELETE ON venta_boletos.viajes
FOR EACH ROW
BEGIN
    UPDATE venta_boletos.autobuses SET estado = 'disponible' WHERE id_autobus = OLD.id_autobus;
END $$
DELIMITER ;

