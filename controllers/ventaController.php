<?php

class ventaController extends baseController
{
    public static function crearVenta($id_cliente, $data, $servicio, $orderId)
    {
        return ventaModel::crearVenta([
            "id_servicio" => $data['id_servicio'],
            "id_cliente" => $id_cliente,
            "id_asesor" => 0,
            "precio" => $servicio['precio'],
            "codigo" => uniqid("VEN-"),
            "order_id" => $orderId,
            "campos_form" => "",
            "fecha_entrega" => date("Y-m-d H:i:s", strtotime("+{$servicio['fecha_entrega']} days"))
        ]);
    }


    public static function actualizarEstadoVenta(
        $id_venta,
        $status,
        $id_cliente,
        $correo_cliente,
        $nombre_cliente,
        $wpp_cliente,
        $servicio_nombre,
        $valor,
        $orderID,
        $id_pago
    ) {

        include_once "functions/correos.php";
        include_once "functions/gmensajeVenta.php";
        include_once "views/modules/functions/pipes.php";
        // Actualizar estado en BD (ejemplo)
        $codigo_seguimiento = generarCodigoLinkVenta(0, "WEB");
        $abono = $valor;
        $datosModel = [
            "id_venta" => $id_venta,
            "estado_pago" => $status,
            "estado" => 1,
            "abono" => $abono,
            "codigo" => $codigo_seguimiento
        ];

        ventaModel::actualizarEstadoVenta($datosModel, "ventas");

        $datosController = [
            "tipo" => "venta_web",
            "codigo" => $codigo_seguimiento,
            "fecha" => date('Y-m-d H:i:s'),
            "data" => $id_venta,
            "estado" => 1
        ];

        switch ($status) {

            case 'processing':
                $estado_pago = 'iniciado';
                break;

            case 'pending': // PSE
                $estado_pago = 'iniciado';
                break;

            case 'approved':
                $estado_pago = 'aprobado';
                break;

            case 'rejected':
                $estado_pago = 'rechazado';
                break;

            case 'failed':
                $estado_pago = 'rechazado';
                break;

            case 'voided':
                $estado_pago = 'rechazado';
                break;

            default:
                $estado_pago = 'Desconocido';
        }

        // ACTUALIZAR LA TABLA PAGOS
        $datosPago = [
            "id_pago" => $id_pago,
            "estado" => $estado_pago,
            "referencia_pasarela" => $orderID,
            "respuesta_pasarela" => $status
        ];

        ventaModel::actualizarPagoWeb($datosPago, "pagos");

        $respuesta = ventaModel::generarLinkVenta($datosController, "enlace_temporal");

        $valor_formateado = formatoPesosColombianos($valor);

        $correo = generarCorreoPorEstado($status, $nombre_cliente, $servicio_nombre, $valor_formateado, $codigo_seguimiento);

        enviarCorreo(
            $correo_cliente,
            $correo['subject'],
            $correo['html']
        );
    }

    private static function enviarWhatsappZenvia($telefono, $nombre, $idVenta)
    {
        $token = "n_6wZNIjIBVM13r5rRXNss9B7hCM_rRG51rz";

        $url = "https://api.zenvia.com/v2/channels/whatsapp/messages";

        $payload = [
            "from" => "573001112233", // TU NÚMERO WHATSAPP BUSINESS
            "to" => $telefono,
            "contents" => [
                [
                    "type" => "template",
                    "templateId" => "venta_aprobada", // ID DEL TEMPLATE
                    "fields" => [
                        "name" => $nombre,
                        "id" => $idVenta
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-API-TOKEN: {$token}"
            ],
            CURLOPT_POSTFIELDS => json_encode($payload)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // (Opcional) Log de respuesta
        // error_log($response);
    }

}
