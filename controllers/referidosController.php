<?php

class referidosController extends baseController
{
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        

        $data = [
            "nombres" => trim($_POST['nombres'] ?? ''),
            "apellidos" => trim($_POST['apellidos'] ?? ''),
            "correo" => trim($_POST['correo'] ?? ''),
            "celular" => trim($_POST['celular'] ?? ''),
            "banco" => trim($_POST['banco'] ?? ''),
            "numero_cuenta" => trim($_POST['numero_cuenta'] ?? ''),
            "tipo_cuenta" => trim($_POST['tipo_cuenta'] ?? ''),
            "cedula" => trim($_POST['cedula'] ?? ''),
        ];

        // Validación básica
        foreach ($data as $value) {
            if (empty($value)) {
                die("Datos incompletos");
            }
        }

        // Generar código único
        $codigo = self::generarCodigoUnico();

       // Guardar referido
        $respuesta = referidoModel::crearReferido([
            "nombres" => $data['nombres'],
            "apellidos" => $data['apellidos'],
            "correo" => $data['correo'],
            "celular" => $data['celular'],
            "banco" => $data['banco'],
            "numero_cuenta" => $data['numero_cuenta'],
            "tipo_cuenta" => $data['tipo_cuenta'],
            "cedula" => $data['cedula'],
            "codigo" => $codigo
        ]);



        include_once "functions/correos.php";

        $subject1 = 'Tu código de referido ya está listo';
        $subject2 = 'Cómo reclamar tu recompensa por referidos';

        $codigo_referido = $codigo; // código generado
        $nombre_cliente = $_POST["nombres"];
        $correo_cliente = $data['correo'];

        /* =========================
           CORREO 1 – CÓDIGO REFERIDO
           ========================= */
        $mensaje1 = '
<html>
<body style="
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #090830;
    color: #fff;
">
    <div style="text-align:center; padding-top:2rem; margin-bottom:20px;">
        <img src="https://apostillasylegalizaciones.com/views/assets/img/logo.png"
             alt="Logo"
             style="max-width:200px;">
    </div>

    <div style="width:100%; max-width:360px; margin:0 auto;">

        <h2 style="text-align:center;">
            Hola ' . $nombre_cliente . ',
        </h2>

        <p style="font-size:16px; text-align:center;">
            ¡Gracias por registrarte como referido! 😊
        </p>

        <p style="font-size:16px; text-align:center;">
            Tu código de referido es:
        </p>

        <div style="
            font-size:22px;
            color:#090830;
            font-weight:bold;
            padding:12px;
            background-color:#ffffff;
            border-radius:10px;
            text-align:center;
            margin:20px 0;
            letter-spacing:2px;
        ">
            ' . $codigo_referido . '
        </div>

        <p style="font-size:15px; text-align:center;">
            Compártelo junto con nuestro número de WhatsApp para que tu amigo
            inicie su trámite de <strong>Apostillas o Convalidación</strong>.
        </p>

        <p style="text-align:center; font-size:15px;">
            📞 <strong>WhatsApp / Llamada (Ventas):</strong><br>
            +57 300 502 3755
        </p>

        <p style="font-size:15px; text-align:center; margin-top:20px;">
            Cada persona que inicie su proceso usando tu código
            genera una recompensa para ti.
        </p>

        <p style="text-align:center; margin:25px 0;">
            <a href="https://api.whatsapp.com/send/?phone=573005023755&text=Hola,%20quiero%20iniciar%20un%20trámite%20con%20el%20código%20' . $codigo_referido . '"
               style="
                   background-color:#11a447;
                   color:white;
                   padding:12px 24px;
                   text-decoration:none;
                   border-radius:5px;
                   font-weight:bold;
                   display:inline-block;
               ">
                Escribir a Ventas por WhatsApp
            </a>
        </p>

        <p style="text-align:center; font-size:14px;">
            ¡Gracias por recomendarnos!
        </p>
    </div>

    <hr style="margin:30px 0; border-color:#ffffff33;">

    <div style="padding-bottom:2rem;">
        <p style="text-align:center; font-size:12px;">
            Este correo fue enviado desde
            <a href="https://apostillasylegalizaciones.com/" style="color:#fff;">
                apostillasylegalizaciones.com
            </a>
        </p>
    </div>
</body>
</html>
';

        /* =========================
           CORREO 2 – RECLAMO BONO
           ========================= */
        $mensaje2 = '
<html>
<body style="
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #090830;
    color: #fff;
">
    <div style="text-align:center; padding-top:2rem; margin-bottom:20px;">
        <img src="https://apostillasylegalizaciones.com/views/assets/img/logo.png"
             alt="Logo"
             style="max-width:200px;">
    </div>

    <div style="width:100%; max-width:360px; margin:0 auto;">

        <h2 style="text-align:center;">
            Hola ' . $nombre_cliente . ',
        </h2>

        <p style="font-size:16px; text-align:center;">
            Aquí te indicamos cómo realizar el seguimiento y reclamo
            de tu recompensa por referidos.
        </p>

        <p style="font-size:15px; text-align:center;">
            Una vez tu amigo haya iniciado su trámite utilizando
            tu código de referido:
        </p>

        <div style="
            font-size:18px;
            color:#090830;
            font-weight:bold;
            padding:12px;
            background-color:#ffffff;
            border-radius:10px;
            text-align:center;
            margin:20px 0;
            letter-spacing:2px;
        ">
            ' . $codigo_referido . '
        </div>

        <p style="font-size:15px; text-align:center;">
            Puedes comunicarte con nuestro equipo de
            <strong>Atención al Cliente</strong> para validar el proceso.
        </p>

        <p style="text-align:center; font-size:15px;">
            📞 <strong>Atención al Cliente:</strong><br>
            +57 317 757 8395
        </p>

        <p style="font-size:15px; text-align:center;">
            Al escribir, indícanos:
        </p>

        <ul style="font-size:15px; color:#fff;">
            <li>Tu código de referido</li>
            <li>Nombre de la persona referida</li>
        </ul>

        <p style="font-size:15px; text-align:center;">
            Nuestro equipo te apoyará con el seguimiento
            y la entrega de tu recompensa.
        </p>

        <p style="text-align:center; margin:25px 0;">
            <a href="https://api.whatsapp.com/send/?phone=573177578395&text=Hola,%20quiero%20hacer%20seguimiento%20a%20mi%20recompensa%20con%20el%20código%20' . $codigo_referido . '"
               style="
                   background-color:#11a447;
                   color:white;
                   padding:12px 24px;
                   text-decoration:none;
                   border-radius:5px;
                   font-weight:bold;
                   display:inline-block;
               ">
                Reclamar recompensa por WhatsApp
            </a>
        </p>

        <p style="text-align:center; font-size:14px;">
            Gracias por recomendarnos y confiar en nuestro servicio.
        </p>
    </div>
</body>
</html>
';

        /* =========================
           ENVÍO DE CORREOS
           ========================= */
        enviarCorreo($correo_cliente, $subject1, $mensaje1);
        enviarCorreo($correo_cliente, $subject2, $mensaje2);


        ?>
        <script>
            window.location.href = "referidos/?codigo=<?php echo $codigo; ?>";
        </script>
        <?php
    }

    // Generar código único de 6 caracteres (A-Z, 0-9)
    private static function generarCodigoUnico()
    {
        do {
            $codigo = self::generarCodigo();
            $existe = referidoModel::codigoExiste($codigo);
        } while ($existe);

        return $codigo;
    }

    private static function generarCodigo()
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codigo = '';

        for ($i = 0; $i < 6; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $codigo;
    }
}
