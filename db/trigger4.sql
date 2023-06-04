DELIMITER //

CREATE TRIGGER EstadoAutobusViaje AFTER UPDATE ON Viajes
FOR EACH ROW
BEGIN
    IF NEW.estado_viaje = 'finalizado' AND OLD.estado_viaje <> 'finalizado' THEN
        UPDATE Autobuses SET estado = 'disponible' WHERE id_autobus = NEW.id_autobus;
    END IF;
END //

DELIMITER ;
