<?php

function formatearFecha($fecha, $soloFecha = false)
{
    if (!$fecha || $fecha === "0000-00-00 00:00:00") {
        return "No se ha ingresado una fecha";
    }

    $meses = [
        "Jan" => "Ene",
        "Feb" => "Feb",
        "Mar" => "Mar",
        "Apr" => "Abr",
        "May" => "May",
        "Jun" => "Jun",
        "Jul" => "Jul",
        "Aug" => "Ago",
        "Sep" => "Sep",
        "Oct" => "Oct",
        "Nov" => "Nov",
        "Dec" => "Dic"
    ];

    try {
        $date = new DateTime($fecha);
        $formato = $soloFecha ? "d M Y" : "d M Y - h:i A"; // Si $soloFecha es true, solo muestra la fecha
        $formatoIngles = $date->format($formato);
        $formatoEspañol = strtr($formatoIngles, $meses);

        return $soloFecha ? $formatoEspañol : str_replace(["AM", "PM"], ["am", "pm"], $formatoEspañol);
    } catch (Exception $e) {
        return "Fecha inválida";
    }
}



function formatoPesosColombianos($numero) {
    return "$" . number_format($numero, 0, ",", ".");
}


