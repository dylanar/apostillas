<?php

class ventaModel
{
    public static function crearVenta($data)
    {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO ventas
            (id_servicio, id_cliente, id_asesor, precio, moneda, abono,
             codigo, order_id, campos_form, cantidad, fecha_entrega,
             estado, estado_pago, fecha)
            VALUES
            (:id_servicio, :id_cliente, :id_asesor, :precio, 'COP', 0,
             :codigo, :order_id, :campos_form, 1, :fecha_entrega,
             0, 'pendiente', NOW())
        ");

        $stmt->execute($data);

        return Conexion::conectar()->lastInsertId();
    }
     public static function generarLinkVenta($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (tipo, codigo, estado, data, fecha) VALUES (:tipo, :codigo, :estado, :data, :fecha)");


        $stmt->bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":data", $datosModel["data"], PDO::PARAM_INT);

        return $stmt->execute() ? "success" : "error";
    }

    public static function actualizarEstadoVenta($datos, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, estado = :estado, estado_pago = :estado_pago, abono = :abono  WHERE id = :id_venta");

        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":id_venta", $datos["id_venta"], PDO::PARAM_INT);
        $stmt->bindParam(":estado_pago", $datos["estado_pago"], PDO::PARAM_STR);
        $stmt->bindParam(":abono", $datos["abono"], PDO::PARAM_STR);

        return $stmt->execute() ? "success" : "error";
    }

   

    public static function actualizarPagoWeb($datos, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  estado = :estado, referencia_pasarela = :referencia_pasarela, respuesta_pasarela = :respuesta_pasarela WHERE id = :id_pago");

        $stmt->bindParam(":respuesta_pasarela", $datos["respuesta_pasarela"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":id_pago", $datos["id_pago"], PDO::PARAM_INT);
        $stmt->bindParam(":referencia_pasarela", $datos["referencia_pasarela"], PDO::PARAM_STR);


        return $stmt->execute() ? "success" : "error";
    }
}
