-- Índices para las consultas activas de la raíz y del panel admin.
-- MariaDB permite IF NOT EXISTS, por lo que este archivo se puede ejecutar más de una vez.

CREATE INDEX IF NOT EXISTS idx_auto_estado_id
    ON auto (vendido, pausado, id);

CREATE INDEX IF NOT EXISTS idx_auto_pausado_id
    ON auto (pausado, id);

CREATE INDEX IF NOT EXISTS idx_auto_estado_consig_precio
    ON auto (vendido, pausado, consig, precio);

CREATE INDEX IF NOT EXISTS idx_auto_estado_precio
    ON auto (vendido, precio);

CREATE INDEX IF NOT EXISTS idx_auto_marca_modelo_estado
    ON auto (id_marca, id_modelo, vendido);

CREATE INDEX IF NOT EXISTS idx_auto_combustible_estado
    ON auto (combustible, vendido);

CREATE INDEX IF NOT EXISTS idx_publicaciones_red_auto
    ON publicaciones (red_social, auto);

CREATE INDEX IF NOT EXISTS idx_autoventas_previo
    ON autoVentas (id_previo);

CREATE INDEX IF NOT EXISTS idx_venta_cliente
    ON venta (id_cliente);

CREATE INDEX IF NOT EXISTS idx_venta_estado
    ON venta (estatus_venta, id);

CREATE INDEX IF NOT EXISTS idx_pago_venta_estado_tipo
    ON pago (id_venta, estatus, tipo_pago);

CREATE INDEX IF NOT EXISTS idx_pago_evento_venta_fecha
    ON pago_evento (id_venta, fecha_prospecto);

CREATE INDEX IF NOT EXISTS idx_visitas_auto_fecha
    ON visitasAuto (auto, fecha);

CREATE INDEX IF NOT EXISTS idx_visitas_fecha
    ON visitasAuto (fecha);

CREATE INDEX IF NOT EXISTS idx_notificaciones_pendientes
    ON notficaiones_s (notificado, id_suscriptor, id_auto, id);

CREATE INDEX IF NOT EXISTS idx_log_auto_id
    ON log_cambio_auto (id_auto, id);

CREATE INDEX IF NOT EXISTS idx_car_hunter_avisado
    ON car_hunter (avisado);
