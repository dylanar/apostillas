<?php

class clienteModel extends Conexion
{
    public static function actualizarVentaPendiente($datos, $tabla)
{
    $conexion = Conexion::conectar();
    $sql = "UPDATE $tabla 
            SET id_cliente  = :id_cliente,
                campos_form = :campos_form,
                estado      = :estado
            WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    try {
        $stmt->execute([
            ':id_cliente'  => $datos['id_cliente'],
            ':campos_form' => $datos['campos_form'],
            ':estado'      => $datos['estado'],
            ':id'          => $datos['id']
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Error al actualizar venta pendiente: " . $e->getMessage());
        return false;
    }
}

    public static function registrarCliente($datos, $tabla)
    {
        $conexion = Conexion::conectar();

        $sql = "INSERT INTO $tabla 
            (nombre, apellido, cedula, telefono, wpp, correo, tomo_servicio, fecha) 
            VALUES 
            (:nombre, :apellido, :cedula, :telefono, :wpp, :correo, :tomo_servicio, :fecha)";

        $stmt = $conexion->prepare($sql);

        try {
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'] ?? '',
                ':cedula' => $datos['cedula'],
                ':telefono' => $datos['telefono'],
                ':wpp' => $datos['wpp'] ?? '',
                ':correo' => $datos['correo'],
                ':tomo_servicio' => $datos['tomo_servicio'],
                ':fecha' => $datos['fecha']
            ]);

            return ["success", $conexion->lastInsertId()];

        } catch (PDOException $e) {
            error_log("Error al registrar cliente: " . $e->getMessage());
            return ["error", $e->getMessage()];
        }
    }

    public static function registrarVenta($datos, $tabla)
    {
        $conexion = Conexion::conectar();

        $sql = "INSERT INTO $tabla 
        (id_servicio, id_cliente, id_asesor, precio, abono, codigo, campos_form, cantidad, fecha_entrega,codigo_referido, fecha) 
        VALUES 
        (:id_servicio, :id_cliente, :id_asesor, :precio, :abono, :codigo, :campos_form, :cantidad, :fecha_entrega, :codigo_referido, :fecha)";

        $stmt = $conexion->prepare($sql);

        try {

            $stmt->execute([
                ':id_servicio' => $datos['id_servicio'],
                ':id_cliente' => $datos['id_cliente'],
                ':id_asesor' => $datos['id_asesor'],
                ':precio' => $datos['precio'],
                ':abono' => $datos['abono'],
                ':codigo' => $datos['codigo'],
                ':campos_form' => $datos['campos_form'],
                ':cantidad' => $datos['cantidad'],
                ':fecha_entrega' => $datos['fecha_entrega'],
                ':fecha' => $datos['fecha'],
                ':codigo_referido' => $datos["codigo_referido"]
            ]);

            return ["success", $conexion->lastInsertId()];

        } catch (PDOException $e) {

            error_log("Error al registrar venta: " . $e->getMessage());
            return ["error", $e->getMessage()];
        }
    }

    public static function subirArchivosFormClientes($datos, $tabla)
    {
        $conexion = Conexion::conectar();

        $sql = "INSERT INTO $tabla (id_venta, nombre, nombre_archivo, ruta, tipo, campo_origen, tipo_ruta, fecha) 
            VALUES (:id_venta, :nombre, :nombre_archivo, :ruta, :tipo, :campo_origen, :tipo_ruta, :fecha)";

        $stmt = $conexion->prepare($sql);

        try {
            $stmt->execute([
                ':id_venta' => $datos['id_venta'],
                ':nombre' => $datos['nombre'],
                ':nombre_archivo' => $datos['nombre_archivo'],
                ':ruta' => $datos['ruta'],
                ':tipo' => $datos['tipo'],
                ':campo_origen' => $datos['campo_origen'],
                ':tipo_ruta' => $datos['tipo_ruta'],
                ':fecha' => $datos['fecha']
            ]);

            return ["success", $conexion->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error al subir archivo: " . $e->getMessage());
            return ["error", $e->getMessage()];
        }
    }

    public static function actualizarCodigoSeguimiento($idCliente, $datos)
    {
        $conexion = Conexion::conectar();

        $sql = "UPDATE clientes SET codigo_seguimiento = :codigo_seguimiento WHERE id = :id";

        $stmt = $conexion->prepare($sql);

        try {
            $stmt->execute([
                ':codigo_seguimiento' => $datos['codigo_seguimiento'],
                ':id' => $idCliente
            ]);

            return ["success"];
        } catch (PDOException $e) {
            error_log("Error al actualizar código: " . $e->getMessage());
            return ["error", $e->getMessage()];
        }
    }

    public static function insertarPagoVenta($datosModel, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("
        INSERT INTO $tabla 
        (id_venta, id_asesor, valor, metodo_pago, estado, fecha_pago, fecha) 
        VALUES 
        (:id_venta, :id_asesor, :valor, :metodo_pago, :estado, :fecha_pago, :fecha)
    ");

        $stmt->bindParam(":id_venta", $datosModel["id_venta"], PDO::PARAM_INT);
        $stmt->bindParam(":id_asesor", $datosModel["id_asesor"], PDO::PARAM_INT);
        $stmt->bindParam(":valor", $datosModel["valor"], PDO::PARAM_STR);
        $stmt->bindParam(":metodo_pago", $datosModel["metodo_pago"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_pago", $datosModel["fecha_pago"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datosModel["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);

        return $stmt->execute() ? "success" : "error";
    }



    public static function actualizarEstadoEnlace($codigo, $estado, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE codigo = :codigo");
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);

        return $stmt->execute() ? "success" : "error";
    }

    public static function buscarPorDocumentoOCorreo($cedula, $correo)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT id FROM clientes
            WHERE cedula = :cedula OR correo = :correo
            LIMIT 1
        ");

        $stmt->bindParam(":cedula", $cedula);
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function crearCliente($data)
    {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO clientes
            (nombre, apellido, cedula, telefono, wpp, correo, tomo_servicio)
            VALUES
            (:nombre, :apellido, :cedula, :telefono, :wpp, :correo, 0)
        ");

        $stmt->execute($data);

        return Conexion::conectar()->lastInsertId();
    }

    public static function marcarClienteComoPagado($id_cliente)
    {
        $stmt = Conexion::conectar()->prepare("
            UPDATE clientes SET tomo_servicio = 1 WHERE id = :id
        ");
        $stmt->bindParam(":id", $id_cliente);
        $stmt->execute();
    }

    public static function actulizarCliebteFormWeb($datos, $tabla)
    {
        $conexion = Conexion::conectar();

        $sql = "UPDATE $tabla SET
                nombre = :nombre,
                apellido = :apellido,
                cedula = :cedula,
                telefono = :telefono,
                wpp = :wpp,
                correo = :correo,
                tomo_servicio = :tomo_servicio
            WHERE id = :id";

        $stmt = $conexion->prepare($sql);

        try {
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'] ?? '',
                ':cedula' => $datos['cedula'],
                ':telefono' => $datos['telefono'],
                ':wpp' => $datos['wpp'] ?? '',
                ':correo' => $datos['correo'],
                ':tomo_servicio' => $datos['tomo_servicio'],
                ':id' => $datos['id']
            ]);

            return ["success", $datos['id']];

        } catch (PDOException $e) {
            error_log("Error al actualizar cliente: " . $e->getMessage());
            return ["error", $e->getMessage()];
        }
    }

    public static function actCamposformVenta($datos, $tabla)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET campos_form = :campos_form WHERE id = :id");

        $stmt->bindParam(":campos_form", $datos["campos_form"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

        return $stmt->execute() ? "success" : "error";
    }

public static function obtenerDatosPorCodigo(string $codigo): ?array
{
    $stmt = Conexion::conectar()->prepare("
        SELECT 
            v.codigo         AS id_venta,
            v.id_servicio,
            v.precio,
            v.abono,
            v.fecha_entrega,
            v.campos_form,
            c.nombre,
            c.apellido,
            c.cedula,
            c.correo
        FROM ventas v
        INNER JOIN clientes c ON c.id = v.id_cliente
        WHERE v.codigo = :codigo
        LIMIT 1
    ");
    $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

}