<?php

class Conexion
{
    private static $conexion = null;

    public static function conectar()
    {
        if (self::$conexion === null) {
            try {
                self::$conexion = new PDO(
                    "mysql:host=localhost;dbname=apostillas;charset=utf8",
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_PERSISTENT => true // Conexión persistente
                    ]
                );
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }

    public static function cerrarConexion()
    {
        self::$conexion = null; // Libera la conexión
    }
}
