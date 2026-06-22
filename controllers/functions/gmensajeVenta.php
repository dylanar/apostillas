<?php


function generarCodigoLinkVenta($id_asesor, $nombre_asesor, $longitudAleatoria = 6)
{
    // Obtener la primera letra del primer nombre en mayúscula
    $nombreLimpio = preg_replace('/[^a-zA-Z\s]/', '', $nombre_asesor); // Remover números y caracteres especiales
    $partesNombre = explode(' ', trim($nombreLimpio));

    if (empty($partesNombre[0])) {
        $inicial = 'WEB'; // Letra por defecto si no hay nombre válido
    } else {
        $inicial = strtoupper(substr($partesNombre[0], 0, 1));
    }

    // Combinar inicial con ID del asesor
    $baseCodigo = $inicial . $id_asesor;

    // Generar caracteres aleatorios (solo mayúsculas y números)
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maxIndex = strlen($caracteres) - 1;
    $aleatorio = '';

    for ($i = 0; $i < $longitudAleatoria; $i++) {
        $aleatorio .= $caracteres[random_int(0, $maxIndex)];
    }

    // Combinar todo
    $codigo = $baseCodigo . $aleatorio;

    return $codigo;
}

function generarCorreoPorEstado(
    $status,
    $nombre_cliente,
    $servicio_nombre,
    $saldo_formateado,
    $codigo_seguimiento
) {

    switch ($status) {

        case 'processing':
            $subject = 'Tu transacción se está procesando';
            $titulo = 'Estamos procesando tu transacción';
            $contenido = 'Tu pago se encuentra en proceso de validación. En cuanto finalice, te notificaremos por este medio.';
            break;

        case 'pending':
            $subject = 'Tu transacción está pendiente de confirmación';
            $titulo = 'Transacción pendiente';
            $contenido = 'Tu pago está pendiente de confirmación por parte del banco. Te informaremos tan pronto tengamos una respuesta.';
            break;

        case 'approved':
            $subject = '¡Tu transacción fue aprobada!';
            $titulo = 'Transacción aprobada';
            $contenido = 'Tu pago fue aprobado exitosamente. Acontinuación recibirás la información correspondiente y un asesor se pondrá en contacto contigo.';
            break;

        case 'rejected':
            $subject = 'Tu transacción no pudo ser aprobada';
            $titulo = 'Transacción rechazada';
            $contenido = 'Tu pago no fue aprobado. Te enviaremos más información por este medio o por WhatsApp.';
            break;

        case 'failed':
            $subject = 'Hubo un problema con tu transacción';
            $titulo = 'Transacción fallida';
            $contenido = 'Ocurrió un inconveniente al procesar tu pago. Te contactaremos con más detalles para ayudarte a continuar.';
            break;

        case 'voided':
            $subject = 'Tu transacción fue anulada';
            $titulo = 'Transacción anulada';
            $contenido = 'La transacción fue anulada correctamente. Si necesitas continuar con el proceso, puedes contactarnos.';
            break;

        default:
            $subject = 'Estado de tu transacción';
            $titulo = 'Estado de la transacción';
            $contenido = 'No fue posible identificar el estado de tu transacción. Por favor contáctanos para ayudarte.';
            break;


    }

    $html = '
    <html>
    <body style="
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background-color: #090830;
        color: #fff;
    ">

        <div style="text-align:center; padding:2rem 0;">
            <img src="https://apostillasylegalizaciones.com/views/assets//img/logo-navidad.png"
                 style="max-width:200px;">
        </div>

        <div style="max-width:320px; margin:0 auto;">

            <h2 style="text-align:center;">
                Hola, ' . htmlspecialchars($nombre_cliente) . '
            </h2>

            <h3 style="text-align:center; font-size: 20px; margin-top:20px;">
                ' . $titulo . '    </br> por valor de ' . $saldo_formateado . '
            </h3>

            <p style="font-size:17px;">
                ' . $contenido . '
            </p>

            <p style="font-size:17px;">
                Servicio: <strong>' . htmlspecialchars($servicio_nombre) . '</strong>
            </p>
' . (
    $status === 'approved' ? '
        <div style="text-align:center; margin:25px 0;">
            <a href="https://apostillasylegalizaciones.com/formulario/' . $codigo_seguimiento . '" style="
                font-size:20px;
                background:#fff;
                color:#090830;
                font-weight:bold;
                padding:12px 20px;
                border-radius:10px;
                text-align:center;
                text-decoration:none;
                display:inline-block;
            ">
                Llenar formulario
            </a>
        </div>

        <p style="font-size:17px; text-align:center;">
            Haz clic en el botón para abrir el formulario y completar la información requerida.
            <br>
            Este paso es necesario para finalizar tu trámite.
        </p>
    ' : ''
) . '
 
            <p style="font-size:17px; text-align:center;">
                Para más información puedes contactarnos:
            </p>

            <p style="text-align:center; margin:25px 0;">
                <a href="https://api.whatsapp.com/send/?phone=573177578395"
                   style="
                        background-color:#11a447;
                        color:#fff;
                        padding:12px 24px;
                        text-decoration:none;
                        border-radius:5px;
                        font-weight:bold;
                   ">
                   Contactar por WhatsApp
                </a>
            </p>

        </div>

        <hr style="margin:30px 0;">

        <p style="text-align:center; font-size:12px; color:#fff;">
            Este correo fue enviado desde
            <a href="https://apostillasylegalizaciones.com/" style="color:#fff;">
                apostillasylegalizaciones.com
            </a><br><br>
            <img src="https://apostillasylegalizaciones.com/views/assets//img/logo-navidad.png"
                 style="max-width:100px;">
        </p>

    </body>
    </html>
    ';

    return [
        'subject' => $subject,
        'html' => $html
    ];
}