<?php

class pagoModel
{
    public static function crearPago($data)
    {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO pagos
            (id_venta, valor, metodo_pago, estado, fecha)
            VALUES
            (:id_venta, :valor, :metodo_pago, 'iniciado', NOW())
        ");

        $stmt->execute($data);

        return Conexion::conectar()->lastInsertId();
    }
}
