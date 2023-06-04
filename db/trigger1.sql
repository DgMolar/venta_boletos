DELIMITER //

CREATE TRIGGER EstadoAutobusUpdate AFTER UPDATE ON Viajes
FOR EACH ROW
BEGIN
    DECLARE estado_autobus VARCHAR(45);
    SELECT estado INTO estado_autobus FROM Autobuses WHERE id_autobus = NEW.id_autobus;
    
    IF estado_autobus = 'disponible' THEN
        UPDATE Autobuses SET estado = 'ocupado' WHERE id_autobus = NEW.id_autobus;
    ELSE
        UPDATE Autobuses SET estado = 'disponible' WHERE id_autobus = NEW.id_autobus;
    END IF;
END //

DELIMITER ;
