CREATE VIEW `vista_boletos` AS
SELECT b.id_boleto, c.nombre, c.apellido, vj.fecha_salida, d.nombre AS destino, b.numero_asiento, vj.costo, emp.nombre_empleado, a.placa
FROM boletos b
JOIN ventas v ON b.id_venta = v.id_venta
JOIN clientes c ON v.id_cliente = c.id_cliente
JOIN viajes vj ON b.id_viaje = vj.id_viaje
JOIN destinos d ON vj.id_destino = d.id_destino
JOIN empleados emp ON v.id_empleado = emp.id_empleado
JOIN autobuses a ON vj.id_autobus = a.id_autobus;
