DROP TRIGGER IF EXISTS EstadoAutobusUpdate;
DELIMITER //

CREATE TRIGGER EstadoAutobusUpdate AFTER UPDATE ON Viajes
FOR EACH ROW
BEGIN
    IF NEW.id_autobus <> OLD.id_autobus THEN
        UPDATE Autobuses SET estado = 'disponible' WHERE id_autobus = OLD.id_autobus;
        UPDATE Autobuses SET estado = 'ocupado' WHERE id_autobus = NEW.id_autobus;
    END IF;
END //

DELIMITER ;
