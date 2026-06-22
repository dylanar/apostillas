<?php

class creditoModel extends Conexion
{
    /* =========================
       BUSCAR SOLICITUD EN PROCESO
    ========================= */
    public static function buscarSolicitudEnProceso($documento, $correo, $celular)
    {
        $conexion = Conexion::conectar();

        $stmt = $conexion->prepare("
            SELECT id 
            FROM solicitudes_credito
            WHERE estado = 'en_proceso'
            AND (
                documento = :documento
                OR correo = :correo
                OR celular = :celular
            )
            LIMIT 1
        ");

        $stmt->execute([
            ":documento" => $documento,
            ":correo"    => $correo,
            ":celular"   => $celular
        ]);

        $existe = $stmt->fetch(PDO::FETCH_ASSOC);

        Conexion::cerrarConexion();

        return $existe ? true : false;
    }


    /* =========================
       CREAR SOLICITUD
    ========================= */
    public static function crearSolicitud($data)
    {
        $conexion = Conexion::conectar();

        $stmt = $conexion->prepare("
            INSERT INTO solicitudes_credito (
                documento,
                nombre,
                celular,
                correo,
                velocidad,
                radicacion,
                impulso,
                pago_men,
                tiempo_estimado,
                total_financiar,
                estado,
                fecha
            ) VALUES (
                :documento,
                :nombre,
                :celular,
                :correo,
                :velocidad,
                :radicacion,
                :impulso,
                :pago_men,
                :tiempo,
                :total,
                'en_proceso',
                NOW()
            )
        ");

        $ok = $stmt->execute([
            ":documento"  => $data["documento"],
            ":nombre"     => $data["nombre"],
            ":celular"    => $data["celular"],
            ":correo"     => $data["correo"],
            ":velocidad"  => $data["velocidad"],
            ":radicacion" => $data["radicacion"],
            ":impulso"    => $data["impulso"],
            ":pago_men"   => $data["pago_men"],
            ":tiempo"     => $data["tiempo"],
            ":total"      => $data["total"],
        ]);

        Conexion::cerrarConexion();

        return $ok;
    }
}
