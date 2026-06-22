<?php

define('WHATSAPP_VENTAS', '573005023755'); 
// Agregar esta función
function formatoPesosColombianos($valor): string
{
    return '$' . number_format((float)$valor, 0, ',', '.');
}
function obtenerNombreServicio($id_servicio)
{
    $servicios = [
        1  => 'Apostilla España',
        5  => 'Apostilla España',
        6  => 'Apostilla España',
        7  => 'Radicación MEN',
        10 => 'Apostilla Colombia',
        11 => 'Apostilla Colombia',
        12 => 'Apostilla Colombia',
        13 => 'Apostilla Colombia',
        14 => 'Estados Unidos',
        15 => 'Estados Unidos',
        16 => 'Recolección de Documentos',
        17 => 'Tutelas',
        18 => 'Asesoría',
        19 => 'Homologación España',
    ];

    return $servicios[(int)$id_servicio] ?? 'Trámite de legalización';
}


function generarMensajeNotificacionAsesor(array $datos): string
{
    $nombre    = html_entity_decode($datos['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $documento = html_entity_decode($datos['documento'] ?? '', ENT_QUOTES, 'UTF-8');
    $correo    = html_entity_decode($datos['correo'] ?? '', ENT_QUOTES, 'UTF-8');

    $lineas = [];
    $lineas[] = "Hola, acabo de finalizar mi registro. Estos son mis datos:";
    $lineas[] = "";
    $lineas[] = "*Servicio:* {$datos['servicio']}";
    $lineas[] = "*Nombre:* {$nombre}";
    $lineas[] = "*Documento:* {$documento}";
    $lineas[] = "*Correo:* {$correo}";
    $lineas[] = "*N° de solicitud:* {$datos['numero_solicitud']}";
    $lineas[] = "*Fecha de solicitud:* " . date('d/m/Y');

    if (!empty($datos['metodo_pago'])) {
        $lineas[] = "*Método de pago:* {$datos['metodo_pago']}";
    }

    if (!empty($datos['fecha_entrega'])) {
        $lineas[] = "*Fecha estimada de entrega:* " . date('d/m/Y', strtotime($datos['fecha_entrega']));
    }

    $lineas[] = "*Saldo pendiente:* " . formatoPesosColombianos($datos['saldo_pendiente']);
    $lineas[] = "";
    $lineas[] = "Quedo atento/a a la información para continuar con el proceso. ¡Gracias!";

    return implode("\n", $lineas);
}

function generarLinkWhatsapp(string $telefono, string $mensaje): string
{
    return "https://api.whatsapp.com/send/?phone={$telefono}&text=" . rawurlencode($mensaje);
}