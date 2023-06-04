DELIMITER //

CREATE PROCEDURE RealizarVentaConBoleto(
  IN nombre_cliente VARCHAR(50),
  IN apellido_cliente VARCHAR(50),
  IN correo_cliente VARCHAR(100),
  IN telefono_cliente VARCHAR(20),
  IN id_viaje INT,
  IN numero_asiento INT,
  IN id_empleado INT,
  IN total DECIMAL(7,2),
  IN id_metodo_pago INT
)
BEGIN
  DECLARE id_cliente INT;
  DECLARE id_venta INT;

  -- Insertar datos del cliente
  INSERT INTO Clientes (nombre, apellido, correo, telefono)
  VALUES (nombre_cliente, apellido_cliente, correo_cliente, telefono_cliente);

  -- Obtener el último ID insertado del cliente
  SET id_cliente = LAST_INSERT_ID();

  -- Crear la venta
  INSERT INTO Ventas (id_cliente, id_empleado, fecha_venta, total, id_metodo_pago)
  VALUES (id_cliente, id_empleado, CURDATE(), total, id_metodo_pago);

  -- Obtener el último ID insertado de la venta
  SET id_venta = LAST_INSERT_ID();

  -- Crear el boleto
  INSERT INTO Boletos (id_venta, id_viaje, numero_asiento)
  VALUES (id_venta, id_viaje, numero_asiento);

END //

DELIMITER ;

