<?php
require_once "conexion.php";

class model extends Conexion
{
    // CONSULTAS A TABLAS EN LA BD
    public static function consultaModel($tabla)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTAS A TABLAS EN LA BD LIMITE 5
    public static function consultaLimiteModel($tabla, $limite)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla ORDER BY id DESC LIMIT :limite");
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTAS A TABLAS EN LA BD CON WHERE
    public static function consultaDondeModel($tabla, $donde, $dato)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde = :dato ORDER BY id DESC");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTAS A TABLAS EN LA BD CON 2 AND UNO SOLO
    public static function consultaDatoAnd2Model($tabla, $donde1, $dato1, $donde2, $dato2, $donde3, $dato3)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde1 = :dato1 AND $donde2 = :dato2 AND $donde3 = :dato3");
        $stmt->bindParam(":dato1", $dato1, PDO::PARAM_STR);
        $stmt->bindParam(":dato2", $dato2, PDO::PARAM_STR);
        $stmt->bindParam(":dato3", $dato3, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTAS A TABLAS EN LA BD CON WHERE
    public static function consultaDondeAndModel($tabla, $donde, $dato, $donde2, $dato2)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde = :dato AND $donde2 = :dato2 ORDER BY id DESC");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->bindParam(":dato2", $dato2, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // NÚMERO DE UNA CONSULTA, SABER CANTIDAD DE DATOS de una tabla
    public static function consultaNumModel($tabla)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM $tabla");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'];
    }

    // CONSULTA CON CONDICIÓN WHERE
    public static function consultaNumDondeModel($tabla, $donde, $dato)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM $tabla WHERE $donde = :dato");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'];
    }

    // CONSULTA CON CONDICIÓN AND
    public static function consultaAndNumModel($tabla, $donde1, $dato1, $donde2, $dato2)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM $tabla WHERE $donde1 = :dato1 AND $donde2 = :dato2");
        $stmt->bindParam(":dato1", $dato1, PDO::PARAM_STR);
        $stmt->bindParam(":dato2", $dato2, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'];
    }

    // CONSULTA POR DATO ESPECÍFICO
    public static function consultaDatoModel($tabla, $donde, $dato)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde = :dato");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTAS CON AND (VARIOS CONDICIONALES)
    public static function consultaDatosAndModel($tabla, $donde1, $dato1, $donde2, $dato2)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde1 = :dato1 AND $donde2 = :dato2 ORDER BY id DESC");
        $stmt->bindParam(":dato1", $dato1, PDO::PARAM_STR);
        $stmt->bindParam(":dato2", $dato2, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // CONSULTA POR RANGO DE FECHA
    public static function consultaRangoFecha($tabla, $donde, $dato, $fecha_inicio_mysql, $fecha_fin_mysql)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $donde = :dato AND fecha BETWEEN STR_TO_DATE(:fecha_inicio_mysql, '%Y/%m/%d') AND STR_TO_DATE(:fecha_fin_mysql, '%Y/%m/%d') ORDER BY id DESC");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_inicio_mysql", $fecha_inicio_mysql, PDO::PARAM_STR);
        $stmt->bindParam(":fecha_fin_mysql", $fecha_fin_mysql, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }

    // ELIMINACIÓN DE UN DATO
    public static function borrarDatoModel($dato, $tabla)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM $tabla WHERE id = :dato");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_INT);
        $success = $stmt->execute();
        Conexion::cerrarConexion();
        return $success ? "success" : "error";
    }

    // ELIMINACIÓN DE UN DATO CON AND
    public static function borrarDatoAndModel($tabla, $donde1, $dato1, $donde2, $dato2)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM $tabla WHERE $donde1 = :dato1 AND $donde2 = :dato2");
        $stmt->bindParam(":dato1", $dato1, PDO::PARAM_STR);
        $stmt->bindParam(":dato2", $dato2, PDO::PARAM_STR);
        $success = $stmt->execute();
        Conexion::cerrarConexion();
        return $success ? "success" : "error";
    }

    // ELIMINACIÓN POR CONDICIÓN ESPECÍFICA
    public static function borrarDatoDondeModel($tabla, $donde, $dato)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("DELETE FROM $tabla WHERE $donde = :dato");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_INT);
        $success = $stmt->execute();
        Conexion::cerrarConexion();
        return $success ? "success" : "error";
    }

    public static function consultaModelPaginado($tabla, $limite, $offset, $orden)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC LIMIT :limite OFFSET :offset");
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function consultaModelBusqueda($tabla, $busqueda, $limite, $offset, $orden)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT * FROM $tabla 
            WHERE nombre LIKE :busqueda 
            OR cedula LIKE :busqueda 
            OR telefono LIKE :busqueda 
            ORDER BY $orden DESC
            LIMIT :offset, :limite"
        );
        $busqueda = "%$busqueda%";
        $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Obtener la cantidad total de resultados encontrados
    public static function consultaNumModelBusqueda($tabla, $busqueda)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT COUNT(*) FROM $tabla 
            WHERE nombre LIKE :busqueda 
            OR cedula LIKE :busqueda 
            OR telefono LIKE :busqueda"
        );
        $busqueda = "%$busqueda%";
        $stmt->bindParam(":busqueda", $busqueda, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function consultaModelPaginadoTutela($tabla, $limite, $offset, $orden)
    {
        $conexion = Conexion::conectar();

        // Consulta paginada
        $stmt = $conexion->prepare(
            "SELECT * FROM $tabla 
             WHERE estado <> 3 AND servicio = 'tutela' 
             ORDER BY $orden DESC 
             LIMIT :limite OFFSET :offset"
        );
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $datos = $stmt->fetchAll();

        // Total sin paginación
        $totalStmt = $conexion->prepare(
            "SELECT COUNT(*) AS total 
             FROM $tabla 
             WHERE estado <> 3 AND servicio = 'tutela'"
        );
        $totalStmt->execute();
        $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

        Conexion::cerrarConexion();

        return [
            'datos' => $datos,
            'total' => $total
        ];
    }


    // 1. Ingreso del mes actual
    public static function ingresoMesActual($tabla = 'saldos')
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT SUM(valor_servicio) AS total 
                FROM $tabla 
                WHERE (pago_inicial + pago_final) = valor_servicio 
                  AND MONTH(fecha) = MONTH(CURRENT_DATE())
                  AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'] ? $result['total'] : 0;
    }

    // 2. Ingreso del mes anterior
    public static function ingresoMesAnterior($tabla = 'saldos')
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT SUM(valor_servicio) AS total 
                FROM $tabla 
                WHERE (pago_inicial + pago_final) = valor_servicio 
                  AND MONTH(fecha) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                  AND YEAR(fecha) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'] ? $result['total'] : 0;
    }

    // 3. Ingreso en un rango de fechas (se reciben por parámetros)
    public static function ingresoPorRango($fechaInicio, $fechaFin, $tabla = 'saldos')
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT SUM(valor_servicio) AS total 
                FROM $tabla 
                WHERE (pago_inicial + pago_final) = valor_servicio 
                  AND fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'] ? $result['total'] : 0;
    }

    // CONSULTA CON CONDICIÓN WHERE - NEGATIVO 
    public static function consultaNumDondeNModel($tabla, $donde, $dato)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM $tabla WHERE $donde != :dato");
        $stmt->bindParam(":dato", $dato, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result['total'];
    }

    public static function consultaModelPaginadoAll($tabla, $limite, $offset, $orden)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC LIMIT :limite OFFSET :offset");
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function consultaModelBusquedaPorServicio($tabla, $servicio, $limite, $offset, $orden)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT * FROM $tabla 
        WHERE servicio = :servicio 
        ORDER BY $orden DESC 
        LIMIT :offset, :limite"
        );
        $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function consultaNumModelPorServicio($tabla, $servicio)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT COUNT(*) as total FROM $tabla WHERE servicio = :servicio"
        );
        $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    //SEGUIMIENTO
    public static function consultaSeguimiento($asesor = null, $paginaActual = 1, $registrosPorPagina = 15)
    {
        $offset = ($paginaActual - 1) * $registrosPorPagina;
        $conexion = Conexion::conectar();

        $sql = "SELECT * FROM servicios WHERE estado NOT IN (7)";
        if (!empty($asesor)) {
            $sql .= " AND id_asesor = :id";
        }
        $sql .= " ORDER BY id DESC LIMIT :offset, :limit";

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor)) {
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);
        }
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $registrosPorPagina, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Conexion::cerrarConexion();
        return $result;
    }

    public static function totalServicios($asesor = null)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM servicios WHERE estado NOT IN (7)";
        if (!empty($asesor)) {
            $sql .= " AND id_asesor = :id";
        }

        $stmt = $conexion->prepare($sql);
        if (!empty($asesor)) {
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);
        }
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        Conexion::cerrarConexion();
        return $total;
    }

    public static function consultaSeguimientoBusqueda($asesor, $busqueda, $offset, $limit, $servicio = '', $tipo_servicio = '', $filtro_fecha = '', $desde = '', $hasta = '')
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT servicios.* FROM servicios
            JOIN clientes ON servicios.id_cliente = clientes.id
            WHERE servicios.estado NOT IN (7)";

        if (!empty($asesor)) {
            $sql .= " AND servicios.id_asesor = :id";
        }

        if (!empty($busqueda)) {
            $sql .= " AND (
            servicios.servicio LIKE :busqueda
            OR servicios.tipo_servicio LIKE :busqueda
            OR clientes.nombre LIKE :busqueda
            OR clientes.telefono LIKE :busqueda
        )";
        }

        if (!empty($servicio)) {
            $sql .= " AND servicios.servicio = :servicio";
        }

        if (!empty($tipo_servicio)) {
            $sql .= " AND servicios.tipo_servicio = :tipo_servicio";
        }

        // Filtro de fecha
        if ($filtro_fecha === 'hoy') {
            $sql .= " AND DATE(servicios.fecha) = CURDATE()";
        } elseif ($filtro_fecha === 'ayer') {
            $sql .= " AND DATE(servicios.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        } elseif ($filtro_fecha === 'semana') {
            $sql .= " AND YEARWEEK(servicios.fecha, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)";
        } elseif ($filtro_fecha === 'mes') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE()) AND YEAR(servicios.fecha) = YEAR(CURDATE())";
        } elseif ($filtro_fecha === 'mes_anterior') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(servicios.fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
        } elseif ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $sql .= " AND DATE(servicios.fecha) BETWEEN :desde AND :hasta";
        }

        $sql .= " ORDER BY servicios.id DESC LIMIT :offset, :limit";

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor))
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);

        if (!empty($busqueda)) {
            $likeBusqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $likeBusqueda, PDO::PARAM_STR);
        }

        if (!empty($servicio))
            $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);

        if (!empty($tipo_servicio))
            $stmt->bindParam(":tipo_servicio", $tipo_servicio, PDO::PARAM_STR);

        if ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $stmt->bindParam(":desde", $desde);
            $stmt->bindParam(":hasta", $hasta);
        }

        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();
        return $result;
    }


    public static function totalSeguimientoBusqueda($asesor, $busqueda, $servicio = '', $tipo_servicio = '', $filtro_fecha = '', $desde = '', $hasta = '')
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM servicios
            JOIN clientes ON servicios.id_cliente = clientes.id
            WHERE servicios.estado NOT IN (7)";

        if (!empty($asesor)) {
            $sql .= " AND servicios.id_asesor = :id";
        }

        if (!empty($busqueda)) {
            $sql .= " AND (
            servicios.servicio LIKE :busqueda
            OR servicios.tipo_servicio LIKE :busqueda
            OR clientes.nombre LIKE :busqueda
            OR clientes.telefono LIKE :busqueda
        )";
        }

        if (!empty($servicio)) {
            $sql .= " AND servicios.servicio = :servicio";
        }

        if (!empty($tipo_servicio)) {
            $sql .= " AND servicios.tipo_servicio = :tipo_servicio";
        }

        // Filtro de fecha
        if ($filtro_fecha === 'hoy') {
            $sql .= " AND DATE(servicios.fecha) = CURDATE()";
        } elseif ($filtro_fecha === 'ayer') {
            $sql .= " AND DATE(servicios.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        } elseif ($filtro_fecha === 'semana') {
            $sql .= " AND YEARWEEK(servicios.fecha, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)";
        } elseif ($filtro_fecha === 'mes') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE()) AND YEAR(servicios.fecha) = YEAR(CURDATE())";
        } elseif ($filtro_fecha === 'mes_anterior') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(servicios.fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
        } elseif ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $sql .= " AND DATE(servicios.fecha) BETWEEN :desde AND :hasta";
        }

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor))
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);

        if (!empty($busqueda)) {
            $likeBusqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $likeBusqueda, PDO::PARAM_STR);
        }

        if (!empty($servicio))
            $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);

        if (!empty($tipo_servicio))
            $stmt->bindParam(":tipo_servicio", $tipo_servicio, PDO::PARAM_STR);

        if ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $stmt->bindParam(":desde", $desde);
            $stmt->bindParam(":hasta", $hasta);
        }

        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        Conexion::cerrarConexion();
        return $total;
    }


    public static function resumenFinancieroPorRango($fechaInicio, $fechaFin, $tabla = 'saldos')
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT 
                SUM(pago_inicial + pago_final) AS total_pagado,
                SUM(valor_servicio - (pago_inicial + pago_final)) AS total_deuda,
                SUM(valor_servicio) AS total_valor_servicio
            FROM $tabla
            WHERE fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();

        return [
            'pagado' => $result['total_pagado'] ?? 0,
            'deuda' => $result['total_deuda'] ?? 0,
            'total' => $result['total_valor_servicio'] ?? 0
        ];
    }

    public static function totalClientesPorRango($fechaDesde, $fechaHasta)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM clientes WHERE DATE(fecha) BETWEEN :desde AND :hasta";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':desde', $fechaDesde);
        $stmt->bindParam(':hasta', $fechaHasta);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public static function serviciosPorRango($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
    SELECT servicio, SUM(cantidad) as total 
    FROM ventas
    WHERE fecha BETWEEN :inicio AND :fin 
    GROUP BY servicio
");
        $stmt->bindParam(':inicio', $fechaInicio);
        $stmt->bindParam(':fin', $fechaFin);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function apostillasEspanaPorRango($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
    SELECT tipo_servicio, SUM(cantidad) as total
    FROM ventas
    WHERE servicio = 'apostillas-espana' AND fecha BETWEEN :inicio AND :fin
    GROUP BY tipo_servicio
");
        $stmt->bindParam(':inicio', $fechaInicio);
        $stmt->bindParam(':fin', $fechaFin);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function apostillasColombiaPorRango($fechaInicio, $fechaFin)
    {
        $stmt = Conexion::conectar()->prepare("
    SELECT tipo_servicio, SUM(cantidad) as total
    FROM servicios
    WHERE servicio = 'apostillas-colombia' AND fecha BETWEEN :inicio AND :fin
    GROUP BY tipo_servicio
");
        $stmt->bindParam(':inicio', $fechaInicio);
        $stmt->bindParam(':fin', $fechaFin);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function totalServiciosPorRango($fechaDesde, $fechaHasta)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT SUM(cantidad) as total FROM ventas WHERE DATE(fecha) BETWEEN :desde AND :hasta";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':desde', $fechaDesde);
        $stmt->bindParam(':hasta', $fechaHasta);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public static function registrarBitacora($datosModel, $tabla)
    {
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare("INSERT INTO $tabla (mensaje, fecha, url, id_servicio, id_asesor) VALUES (:mensaje, :fecha, :url, :id_servicio, :id_asesor)");

        $stmt->bindParam(":mensaje", $datosModel["mensaje"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":url", $datosModel["url"], PDO::PARAM_STR);
        $stmt->bindParam(":id_servicio", $datosModel["id_servicio"], PDO::PARAM_INT);
        $stmt->bindParam(":id_asesor", $datosModel["id_asesor"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "success";
        } else {
            return "error";
        }
    }


    public static function consultaBitacora($filtro = null, $fechaInicio = null, $fechaFin = null)
    {
        // Establecer zona horaria de Bogotá
        date_default_timezone_set('America/Bogota');

        $conexion = Conexion::conectar();
        $query = "SELECT * FROM bitacora WHERE 1=1 ";

        if ($filtro) {
            switch ($filtro) {
                case "hoy":
                    $hoy = date('Y-m-d');
                    $query .= " AND DATE(fecha) = :hoy ";
                    break;

                case "ayer":
                    $ayer = date('Y-m-d', strtotime('-1 day'));
                    $query .= " AND DATE(fecha) = :ayer ";
                    break;

                case "7dias":
                    $sieteDias = date('Y-m-d H:i:s', strtotime('-7 days'));
                    $query .= " AND fecha >= :sieteDias ";
                    break;

                case "mes":
                    $query .= " AND MONTH(fecha) = MONTH(CURRENT_DATE()) 
                          AND YEAR(fecha) = YEAR(CURRENT_DATE()) ";
                    break;

                case "mesAnterior":
                    $primerDiaMesAnterior = date('Y-m-01 00:00:00', strtotime('first day of last month'));
                    $ultimoDiaMesAnterior = date('Y-m-t 23:59:59', strtotime('last month'));
                    $query .= " AND fecha BETWEEN :primerDiaMesAnterior AND :ultimoDiaMesAnterior ";
                    break;

                case "rango":
                    if ($fechaInicio && $fechaFin) {
                        // Validar formato de fechas
                        if (
                            DateTime::createFromFormat('Y-m-d', $fechaInicio) &&
                            DateTime::createFromFormat('Y-m-d', $fechaFin)
                        ) {

                            // Ajustar rango completo de día
                            $fechaInicioCompleta = $fechaInicio . " 00:00:00";
                            $fechaFinCompleta = $fechaFin . " 23:59:59";

                            $query .= " AND fecha BETWEEN :fechaInicio AND :fechaFin ";
                        } else {
                            throw new Exception("Formato de fecha inválido. Use YYYY-MM-DD");
                        }
                    }
                    break;
            }
        }

        $query .= " ORDER BY id DESC";
        $stmt = $conexion->prepare($query);

        // Asignar parámetros según el filtro
        if ($filtro) {
            switch ($filtro) {
                case "hoy":
                    $hoy = date('Y-m-d');
                    $stmt->bindValue(":hoy", $hoy);
                    break;

                case "ayer":
                    $ayer = date('Y-m-d', strtotime('-1 day'));
                    $stmt->bindValue(":ayer", $ayer);
                    break;

                case "7dias":
                    $sieteDias = date('Y-m-d H:i:s', strtotime('-7 days'));
                    $stmt->bindValue(":sieteDias", $sieteDias);
                    break;

                case "mesAnterior":
                    $primerDiaMesAnterior = date('Y-m-01 00:00:00', strtotime('first day of last month'));
                    $ultimoDiaMesAnterior = date('Y-m-t 23:59:59', strtotime('last month'));
                    $stmt->bindValue(":primerDiaMesAnterior", $primerDiaMesAnterior);
                    $stmt->bindValue(":ultimoDiaMesAnterior", $ultimoDiaMesAnterior);
                    break;

                case "rango":
                    if ($fechaInicio && $fechaFin) {
                        $fechaInicioCompleta = $fechaInicio . " 00:00:00";
                        $fechaFinCompleta = $fechaFin . " 23:59:59";
                        $stmt->bindValue(":fechaInicio", $fechaInicioCompleta);
                        $stmt->bindValue(":fechaFin", $fechaFinCompleta);
                    }
                    break;
            }
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();

        // Restablecer zona horaria por defecto si es necesario
        date_default_timezone_set('UTC');

        return $result;
    }


    public static function resumenFinancieroEspanaPorRango($fechaInicio, $fechaFin)
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT 
            SUM(saldos.pago_inicial + saldos.pago_final) AS total_pagado,
            SUM(saldos.valor_servicio - (saldos.pago_inicial + saldos.pago_final)) AS total_deuda,
            SUM(saldos.valor_servicio) AS total_valor_servicio
        FROM saldos
        JOIN servicios ON saldos.id_servicio = servicios.id
        WHERE servicios.servicio = 'apostillas-espana' 
          AND saldos.fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();

        return [
            'pagado' => $result['total_pagado'] ?? 0,
            'deuda' => $result['total_deuda'] ?? 0,
            'total' => $result['total_valor_servicio'] ?? 0
        ];
    }

    public static function resumenFinancieroColombiaPorRango($fechaInicio, $fechaFin)
    {
        $conexion = Conexion::conectar();
        $sql = "SELECT 
            SUM(saldos.pago_inicial + saldos.pago_final) AS total_pagado,
            SUM(saldos.valor_servicio - (saldos.pago_inicial + saldos.pago_final)) AS total_deuda,
            SUM(saldos.valor_servicio) AS total_valor_servicio
        FROM saldos
        JOIN servicios ON saldos.id_servicio = servicios.id
        WHERE servicios.servicio = 'apostillas-colombia' 
          AND saldos.fecha BETWEEN :fechaInicio AND :fechaFin";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();

        return [
            'pagado' => $result['total_pagado'] ?? 0,
            'deuda' => $result['total_deuda'] ?? 0,
            'total' => $result['total_valor_servicio'] ?? 0
        ];
    }

    // ===================== SERVICIOS FINALIZADOS =====================

    // Consulta paginada de finalizados
    public static function consultaFinalizados($asesor = null, $paginaActual = 1, $registrosPorPagina = 15)
    {
        $offset = ($paginaActual - 1) * $registrosPorPagina;
        $conexion = Conexion::conectar();

        $sql = "SELECT * FROM servicios WHERE estado = 7";
        if (!empty($asesor)) {
            $sql .= " AND id_asesor = :id";
        }
        $sql .= " ORDER BY id DESC LIMIT :offset, :limit";

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor)) {
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);
        }
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $registrosPorPagina, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Conexion::cerrarConexion();
        return $result;
    }

    // Total de registros finalizados
    public static function totalFinalizados($asesor = null)
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM servicios WHERE estado = 7";
        if (!empty($asesor)) {
            $sql .= " AND id_asesor = :id";
        }

        $stmt = $conexion->prepare($sql);
        if (!empty($asesor)) {
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);
        }
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        Conexion::cerrarConexion();
        return $total;
    }

    // Consulta con búsqueda y filtros (para finalizados)
    public static function consultaFinalizadosBusqueda($asesor, $busqueda, $offset, $limit, $servicio = '', $tipo_servicio = '', $filtro_fecha = '', $desde = '', $hasta = '')
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT servicios.* FROM servicios
            JOIN clientes ON servicios.id_cliente = clientes.id
            WHERE servicios.estado = 7";

        if (!empty($asesor)) {
            $sql .= " AND servicios.id_asesor = :id";
        }

        if (!empty($busqueda)) {
            $sql .= " AND (
            servicios.servicio LIKE :busqueda
            OR servicios.tipo_servicio LIKE :busqueda
            OR clientes.nombre LIKE :busqueda
            OR clientes.telefono LIKE :busqueda
        )";
        }

        if (!empty($servicio)) {
            $sql .= " AND servicios.servicio = :servicio";
        }

        if (!empty($tipo_servicio)) {
            $sql .= " AND servicios.tipo_servicio = :tipo_servicio";
        }

        // Filtro de fechas
        if ($filtro_fecha === 'hoy') {
            $sql .= " AND DATE(servicios.fecha) = CURDATE()";
        } elseif ($filtro_fecha === 'ayer') {
            $sql .= " AND DATE(servicios.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        } elseif ($filtro_fecha === 'semana') {
            $sql .= " AND YEARWEEK(servicios.fecha, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)";
        } elseif ($filtro_fecha === 'mes') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE()) AND YEAR(servicios.fecha) = YEAR(CURDATE())";
        } elseif ($filtro_fecha === 'mes_anterior') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(servicios.fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
        } elseif ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $sql .= " AND DATE(servicios.fecha) BETWEEN :desde AND :hasta";
        }

        $sql .= " ORDER BY servicios.id DESC LIMIT :offset, :limit";

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor))
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);

        if (!empty($busqueda)) {
            $likeBusqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $likeBusqueda, PDO::PARAM_STR);
        }

        if (!empty($servicio))
            $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);

        if (!empty($tipo_servicio))
            $stmt->bindParam(":tipo_servicio", $tipo_servicio, PDO::PARAM_STR);

        if ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $stmt->bindParam(":desde", $desde);
            $stmt->bindParam(":hasta", $hasta);
        }

        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Conexion::cerrarConexion();
        return $result;
    }

    // Total con búsqueda
    public static function totalFinalizadosBusqueda($asesor, $busqueda, $servicio = '', $tipo_servicio = '', $filtro_fecha = '', $desde = '', $hasta = '')
    {
        $conexion = Conexion::conectar();

        $sql = "SELECT COUNT(*) as total FROM servicios
            JOIN clientes ON servicios.id_cliente = clientes.id
            WHERE servicios.estado = 7";

        if (!empty($asesor)) {
            $sql .= " AND servicios.id_asesor = :id";
        }

        if (!empty($busqueda)) {
            $sql .= " AND (
            servicios.servicio LIKE :busqueda
            OR servicios.tipo_servicio LIKE :busqueda
            OR clientes.nombre LIKE :busqueda
            OR clientes.telefono LIKE :busqueda
        )";
        }

        if (!empty($servicio)) {
            $sql .= " AND servicios.servicio = :servicio";
        }

        if (!empty($tipo_servicio)) {
            $sql .= " AND servicios.tipo_servicio = :tipo_servicio";
        }

        // Filtro de fechas
        if ($filtro_fecha === 'hoy') {
            $sql .= " AND DATE(servicios.fecha) = CURDATE()";
        } elseif ($filtro_fecha === 'ayer') {
            $sql .= " AND DATE(servicios.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        } elseif ($filtro_fecha === 'semana') {
            $sql .= " AND YEARWEEK(servicios.fecha, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1)";
        } elseif ($filtro_fecha === 'mes') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE()) AND YEAR(servicios.fecha) = YEAR(CURDATE())";
        } elseif ($filtro_fecha === 'mes_anterior') {
            $sql .= " AND MONTH(servicios.fecha) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(servicios.fecha) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
        } elseif ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $sql .= " AND DATE(servicios.fecha) BETWEEN :desde AND :hasta";
        }

        $stmt = $conexion->prepare($sql);

        if (!empty($asesor))
            $stmt->bindParam(":id", $asesor, PDO::PARAM_INT);

        if (!empty($busqueda)) {
            $likeBusqueda = "%" . $busqueda . "%";
            $stmt->bindParam(":busqueda", $likeBusqueda, PDO::PARAM_STR);
        }

        if (!empty($servicio))
            $stmt->bindParam(":servicio", $servicio, PDO::PARAM_STR);

        if (!empty($tipo_servicio))
            $stmt->bindParam(":tipo_servicio", $tipo_servicio, PDO::PARAM_STR);

        if ($filtro_fecha === 'rango' && !empty($desde) && !empty($hasta)) {
            $stmt->bindParam(":desde", $desde);
            $stmt->bindParam(":hasta", $hasta);
        }

        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        Conexion::cerrarConexion();
        return $total;
    }

    public static function consultaVentasAsesor($idAsesor, $filtro = null, $fechaInicio = null, $fechaFin = null)
    {
        date_default_timezone_set('America/Bogota');
        $conexion = Conexion::conectar();

        $query = "
        SELECT 
            s.servicio,
            s.tipo_servicio,
            SUM(s.cantidad) AS total_cantidad,
            SUM(sd.valor_servicio) AS total_vendido,
            SUM(sd.pago_inicial + sd.pago_final) AS total_pagado,
            SUM(sd.valor_servicio - (sd.pago_inicial + sd.pago_final)) AS total_pendiente
        FROM servicios s
        INNER JOIN saldos sd ON sd.id_servicio = s.id
        WHERE s.id_asesor = :idAsesor
    ";

        // Filtro por fecha
        if ($filtro) {
            switch ($filtro) {
                case "hoy":
                    $query .= " AND DATE(s.fecha) = CURDATE() ";
                    break;
                case "ayer":
                    $query .= " AND DATE(s.fecha) = CURDATE() - INTERVAL 1 DAY ";
                    break;
                case "7dias":
                    $query .= " AND s.fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY) ";
                    break;
                case "mes":
                    $query .= " AND MONTH(s.fecha) = MONTH(CURRENT_DATE()) 
                            AND YEAR(s.fecha) = YEAR(CURRENT_DATE()) ";
                    break;
                case "mesAnterior":
                    $query .= " AND MONTH(s.fecha) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                            AND YEAR(s.fecha) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) ";
                    break;
                case "rango":
                    if ($fechaInicio && $fechaFin) {
                        $query .= " AND s.fecha BETWEEN :fechaInicio AND :fechaFin ";
                    }
                    break;
            }
        }

        $query .= " GROUP BY s.servicio, s.tipo_servicio 
                ORDER BY s.servicio ASC";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(":idAsesor", $idAsesor, PDO::PARAM_INT);

        if ($filtro === "rango" && $fechaInicio && $fechaFin) {
            $stmt->bindValue(":fechaInicio", $fechaInicio . " 00:00:00");
            $stmt->bindValue(":fechaFin", $fechaFin . " 23:59:59");
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Conexion::cerrarConexion();

        return $result;
    }

    public static function consultaServiciosAsesorDetalle($idAsesor, $filtro = null, $fechaInicio = null, $fechaFin = null)
    {
        date_default_timezone_set('America/Bogota');
        $conexion = Conexion::conectar();

        $query = "
        SELECT 
            s.id AS id_servicio,
            s.servicio,
            s.tipo_servicio,
            s.estado,
            s.cantidad,
            s.fecha,
            c.id AS id_cliente,
            c.nombre AS nombre_cliente,
            sd.valor_servicio,
            sd.pago_inicial,
            sd.pago_final
        FROM servicios s
        INNER JOIN saldos sd ON sd.id_servicio = s.id
        INNER JOIN clientes c ON c.id = s.id_cliente
        WHERE s.id_asesor = :idAsesor
    ";

        // Aplicar filtros de fecha
        if ($filtro) {
            switch ($filtro) {
                case "hoy":
                    $query .= " AND DATE(s.fecha) = CURDATE() ";
                    break;
                case "ayer":
                    $query .= " AND DATE(s.fecha) = CURDATE() - INTERVAL 1 DAY ";
                    break;
                case "7dias":
                    $query .= " AND s.fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY) ";
                    break;
                case "mes":
                    $query .= " AND MONTH(s.fecha) = MONTH(CURRENT_DATE()) 
                            AND YEAR(s.fecha) = YEAR(CURRENT_DATE()) ";
                    break;
                case "mesAnterior":
                    $query .= " AND MONTH(s.fecha) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                            AND YEAR(s.fecha) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) ";
                    break;
                case "rango":
                    if ($fechaInicio && $fechaFin) {
                        $query .= " AND s.fecha BETWEEN :fechaInicio AND :fechaFin ";
                    }
                    break;
            }
        }

        $query .= " ORDER BY s.fecha DESC, s.id DESC";

        $stmt = $conexion->prepare($query);
        $stmt->bindValue(":idAsesor", $idAsesor, PDO::PARAM_INT);

        if ($filtro === "rango" && $fechaInicio && $fechaFin) {
            $stmt->bindValue(":fechaInicio", $fechaInicio . " 00:00:00");
            $stmt->bindValue(":fechaFin", $fechaFin . " 23:59:59");
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Conexion::cerrarConexion();

        return $result;
    }

    public static function consultaClientesPorRango($tabla, $fecha1, $fecha2)
    {
        $stmt = Conexion::conectar()->prepare(
            "SELECT * FROM $tabla 
         WHERE fecha BETWEEN :f1 AND :f2
         ORDER BY fecha DESC"
        );

        $stmt->bindParam(":f1", $fecha1, PDO::PARAM_STR);
        $stmt->bindParam(":f2", $fecha2, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll();
    }
}
