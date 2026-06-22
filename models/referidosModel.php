<?php

class referidoModel extends Conexion
{
    // Verificar si un código ya existe
    public static function codigoExiste($codigo)
    {
        $stmt = Conexion::conectar()->prepare("
            SELECT id FROM referidos WHERE codigo = :codigo LIMIT 1
        ");
        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Guardar referido
   public static function crearReferido($data)
{
    try {
        $stmt = Conexion::conectar()->prepare("
            INSERT INTO referidos
            (nombres, apellidos, correo, celular, banco, numero_cuenta, tipo_cuenta, cedula, codigo)
            VALUES
            (:nombres, :apellidos, :correo, :celular, :banco, :numero_cuenta, :tipo_cuenta, :cedula, :codigo)
        ");

        return $stmt->execute([
            ":nombres"        => $data['nombres'],
            ":apellidos"      => $data['apellidos'],
            ":correo"         => $data['correo'],
            ":celular"        => $data['celular'],
            ":banco"          => $data['banco'],
            ":numero_cuenta"  => $data['numero_cuenta'],
            ":tipo_cuenta"    => $data['tipo_cuenta'],
            ":cedula"         => $data['cedula'],
            ":codigo"         => $data['codigo']
        ]);

    } catch (PDOException $e) {
        // Muestra el error real en pantalla temporalmente
        die("Error SQL: " . $e->getMessage());
    }
}
}
