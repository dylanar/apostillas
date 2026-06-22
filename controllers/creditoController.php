<?php

class creditoController extends baseController
{
    public function crearSolicitud()
    {
        if (!isset($_POST["enviarSolicitud"])) {
            return;
        }

        include_once "functions/correos.php";
        include_once "functions/wpp.php";

        /* =========================
           LIMPIAR DATOS
        ========================= */
        $datos = [
            "documento" => htmlspecialchars($_POST["documento"] ?? ""),
            "nombre" => htmlspecialchars($_POST["nombre"] ?? ""),
            "celular" => htmlspecialchars($_POST["celular"] ?? ""),
            "correo" => htmlspecialchars($_POST["correo"] ?? ""),

            "velocidad" => htmlspecialchars($_POST["velocidad"] ?? ""),
            "radicacion" => htmlspecialchars($_POST["radicacion"] ?? ""),
            "impulso" => htmlspecialchars($_POST["impulso"] ?? ""),
            "pago_men" => htmlspecialchars($_POST["pago_men"] ?? ""),

            "tiempo" => htmlspecialchars($_POST["tiempo"] ?? ""),
            "total" => htmlspecialchars($_POST["total"] ?? ""),
        ];

        /* =========================
           VALIDACIÓN BÁSICA
        ========================= */
        if (
            empty($datos["documento"]) ||
            empty($datos["nombre"]) ||
            empty($datos["celular"]) ||
            empty($datos["correo"])
        ) {
            $this->mostrarAlerta("error", "Faltan datos obligatorios.", "credito");
            return;
        }

        /* =========================
           VALIDAR DUPLICADOS
        ========================= */
        $existe = creditoModel::buscarSolicitudEnProceso(
            $datos["documento"],
            $datos["correo"],
            $datos["celular"]
        );

        if ($existe) {
            $this->mostrarAlerta(
                "error",
                "Ya tienes una solicitud en proceso. Nuestro equipo te contactará pronto.",
                "credito"
            );
            return;
        }

        /* =========================
           INSERTAR SOLICITUD
        ========================= */
        $ok = creditoModel::crearSolicitud($datos);

        if (!$ok) {
            $this->mostrarAlerta("error", "Error al registrar la solicitud.", "credito");
            return;
        }

        /* =========================
           ENVIAR CORREO CONFIRMACIÓN
        ========================= */

        $nombre_cliente = $datos["nombre"];
        $correo_cliente = $datos["correo"];
        $total_solicitado = $datos["total"];

        $subject = "Hemos recibido tu solicitud de crédito";

        $mensaje = '
    <html>
    <body style="
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background-color: #090830;
        color: #fff;
    ">
        <div style="text-align:center; margin-bottom:20px; padding-top:2rem">
            <img src="https://apostillasylegalizaciones.com/views/assets/img/logo.png"
                 style="max-width:200px">
        </div>

        <div style="width:100%; box-sizing:border-box; margin:0 auto; padding:2rem;">
            <h2 style="text-align:center;">
                Hola, ' . $nombre_cliente . '
            </h2>

            <p style="font-size:17px; text-align:center;">
                Hemos recibido correctamente tu solicitud de crédito.
            </p>

            <p style="font-size:17px; text-align:center;">
                <strong>Estado actual:</strong> EN PROCESO
            </p>

            <p style="font-size:17px; text-align:center;">
                <strong>Monto solicitado:</strong><br>
                ' . $total_solicitado . '
            </p>

            <p style="font-size:17px; text-align:center;">
                Nuestro equipo está evaluando tu solicitud y se comunicará contigo
                en el menor tiempo posible.
            </p>

            <hr style="margin:30px 0" />

            <p style="text-align:center; font-size:14px;">
                Este mensaje fue enviado automáticamente por nuestro sistema.
            </p>
        </div>

        <div style="padding-bottom:2rem;">
            <p style="text-align:center; font-size:12px; color:#fff">
                © ' . date("Y") . ' apostillasylegalizaciones.com
            </p>
        </div>
    </body>
    </html>';

        enviarCorreo($correo_cliente, $subject, $mensaje);

        // Usar el celular que viene del formulario
        $wpp_cliente = "573177578395" ;
        enviarWhatsAppZenviaTemplate(
            $wpp_cliente,
            "8d2324f5-d100-40ed-b2a6-79a48942a40b",
            [
                "nombre" => $datos["nombre"],
                "cc" => $datos["documento"],
                "correo" => $datos["correo"],
                "telefono" => $wpp_cliente
            ],
            "credito_" . time() // externalId opcional para tracking
        );


        $this->mostrarAlerta(
            "success",
            "Tu solicitud fue enviada correctamente. Revisa tu correo electrónico.",
            "credito/success"
        );
    }


}
