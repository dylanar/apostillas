<?php

class clienteController extends baseController
{
    // verificar codigo registro cliente
    public function verificarCodigoRegistroCliente()
    {
        if (!isset($_POST["verificar_codigo"]))
            return;

        $codigo = $_POST["codigo"];

        $respuesta = model::consultaDatoModel("enlace_temporal", "codigo", $codigo);

        if (count($respuesta) > 0) {
            if ($respuesta["estado"] != 1) {
                $this->mostrarAlerta("info", "El código ingresado se ha vencido, para más información comuniquese con un asesor.", "registro");
                return;
            } else {
                $this->mostrarAlerta("success", "🎉 ¡Excelente! Su código ha sido validado. Ahora, por favor complete el formulario para continuar con su trámite.", "formulario/" . $codigo);
                return;
            }
        } else {
            $this->mostrarAlerta("error", "El código ingresado no existe en nuestro sistema, comuniquese con un asesor.", "registro");
            return;
        }
    }
    // CREAR CLIENTE - FORMULARIO
    public function crearClienteForm()
    {
        if (!isset($_POST["formRegistroCliente"]))
            return;


        // Verificar si existe el campo que indica el paso 1
        if (!isset($_POST['paso1_nombres'])) {
            $this->mostrarAlerta("error", "Datos incompletos.", "formulario");
            return;
        }

        $tzBogota = new DateTimeZone('America/Bogota');
        $fechaBogota = new DateTime('now', $tzBogota);
        $fechaHoy = new DateTime('now', $tzBogota);
        $fechaFormateada = $fechaBogota->format('Y-m-d H:i:s');

        // Carpeta donde se guardarán los archivos
        $uploads_dir = 'uploads/forms/';
        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        // ============================================
        // PASO 1: DATOS PERSONALES (siempre vienen con prefijo 'paso1_')
        // ============================================

        if (isset($_POST["id_cliente"])) {
            $idCliente = $_POST["id_cliente"];

            $datosCliente = [
                "nombre" => htmlspecialchars($_POST["paso1_nombres"] ?? ""),
                "apellido" => htmlspecialchars($_POST["paso1_apellidos"] ?? ""),
                "cedula" => htmlspecialchars($_POST["paso1_cedula"] ?? ""),
                "telefono" => htmlspecialchars($_POST["paso1_celular"] ?? ""),
                "wpp" => htmlspecialchars($_POST["paso1_whatsapp"] ?? ""),
                "correo" => htmlspecialchars($_POST["paso1_correo"] ?? ""),
                "tomo_servicio" => 1,
                "id" => $idCliente
            ];       

            $respuestaCliente = clienteModel::actulizarCliebteFormWeb($datosCliente, "clientes");
        } else {
            $datosCliente = [
                "nombre" => htmlspecialchars($_POST["paso1_nombres"] ?? ""),
                "apellido" => htmlspecialchars($_POST["paso1_apellidos"] ?? ""),
                "cedula" => htmlspecialchars($_POST["paso1_cedula"] ?? ""),
                "telefono" => htmlspecialchars($_POST["paso1_celular"] ?? ""),
                "wpp" => htmlspecialchars($_POST["paso1_whatsapp"] ?? ""),
                "correo" => htmlspecialchars($_POST["paso1_correo"] ?? ""),
                "tomo_servicio" => 1,
                "fecha" => $fechaFormateada
            ];

            // Validar datos mínimos del cliente
            if (
                empty($datosCliente["nombre"]) || empty($datosCliente["cedula"]) ||
                empty($datosCliente["telefono"]) || empty($datosCliente["correo"])
            ) {
                $this->mostrarAlerta("error", "Faltan datos personales obligatorios.", "formulario");
                return;
            }

            $respuestaCliente = clienteModel::registrarCliente($datosCliente, "clientes");

            if (!is_array($respuestaCliente) || $respuestaCliente[0] !== "success") {
                $this->mostrarAlerta("error", "Error al registrar cliente.", "formulario");
                return;
            }

            $idCliente = $respuestaCliente[1];
        }



        // ============================================
        // PASO 2: DATOS DINÁMICOS DEL FORMULARIO
        // ============================================
        // Separar campos de texto y archivos

        $camposArchivos = [];
        $camposTexto = [];

        // 1. Campos ocultos del sistema que NO deben guardarse
        $excluirCamposSistema = [
            'btnRegistroCliente',
            'servicio',
            'formRegistroCliente',
            'codigo_seguimiento',
            'id_servicio',
            'id_asesor',
            'id_cliente',
            'cantidad_doc',
            'abono_inicial',
            'precio',
            'nombre_asesor',
            'fecha_entrega',
            'codigo_referido'
        ];

        // 2. Prefijos que queremos excluir (Paso 1)
        $excluirPrefijos = [
            'paso1_',   // si los campos del paso 1 tienen prefijo
        ];

        // 3. Campos específicos del Paso 1 (sin prefijo)
        $excluirPaso1Directos = [
            'nombres',
            'apellidos',
            'correo',
            'celular',
            'whatsapp',
            'cedula',
            'metodo_pago',
            'fecha_pago'
        ];

        foreach ($_POST as $key => $value) {

            // A. Excluir campos ocultos del sistema
            if (in_array($key, $excluirCamposSistema)) {
                continue;
            }

            // B. Excluir por prefijo (paso1_)
            foreach ($excluirPrefijos as $prefijo) {
                if (strpos($key, $prefijo) === 0) {
                    continue 2;
                }
            }

            // C. Excluir campos del paso 1 sin prefijo
            if (in_array($key, $excluirPaso1Directos)) {
                continue;
            }

            // D. Guardar el resto
            $camposTexto[$key] = htmlspecialchars($value);
        }



        // Procesar archivos del formulario
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                // Excluir archivos del paso 1 si los hubiera
                if (strpos($key, 'paso1_') === 0) {
                    continue;
                }

                if ($file['error'] === UPLOAD_ERR_OK) {
                    $camposArchivos[$key] = $file;
                } else if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                    // Error en la subida (no es "no file")
                    $this->mostrarAlerta("error", "Error al subir archivo: " . $key, "formulario");
                    return;
                }
            }
        }

        // ============================================
        // REGISTRAR SERVICIO
        // ============================================

        $asesor = $_POST["id_asesor"] ?? 0;
         // $codigoVenta = $this->generarCodigoLinkVenta($asesor, $_POST["nombre_asesor"]);
        $codigoVenta = $_POST["codigo_seguimiento"];

        // $dias_entrega = $_POST["fecha_entrega"];
        // $fechaHoy->modify("+{$dias_entrega} days");
        // // Convertir a datetime
        // $fecha_de_entrega = $fechaHoy->format("Y-m-d H:i:s");
        $dias_entrega = (int) $_POST["fecha_entrega"];
        $fecha_de_entrega = self::sumarDiasHabiles($dias_entrega);

        $datosVenta = [
            "id_servicio" => $_POST["id_servicio"],
            "id_cliente" => $idCliente, // o un tipo específico si lo tienes
            "id_asesor" => $asesor,
            "precio" => $_POST["precio"],
            "abono" => $_POST["abono_inicial"],
            "codigo" => $codigoVenta,
            "campos_form" => json_encode($camposTexto, JSON_UNESCAPED_UNICODE),
            "cantidad" => $_POST["cantidad_doc"],
            "fecha_entrega" => $fecha_de_entrega,
            "codigo_referido" => $_POST["codigo_referido"] ?? "",
            "fecha" => $fechaFormateada
        ];

        $respuestaVenta = clienteModel::registrarVenta($datosVenta, "ventas");

        if (!is_array($respuestaVenta) || $respuestaVenta[0] !== "success") {
            $this->mostrarAlerta("error", "Error al registrar la venta.", "formulario");
            return;
        }

        $idVenta = $respuestaVenta[1];

        // ============================================
        // PROCESAR ARCHIVOS DEL PASO 2
        // ============================================
        if (!empty($camposArchivos)) {

            foreach ($camposArchivos as $campoNombre => $archivo) {

                if ($archivo['error'] === UPLOAD_ERR_OK) {

                    $file_tmp = $archivo['tmp_name'];
                    $file_name = basename($archivo['name']);
                    $file_type = mime_content_type($file_tmp);

                    // Tipos permitidos
                    $tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

                    if (in_array($file_type, $tiposPermitidos)) {

                        // Crear nombre seguro
                        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                        $nombreSinEspacios = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
                        $nombreSinExtension = pathinfo($nombreSinEspacios, PATHINFO_FILENAME);

                        $nuevo_nombre =
                            $idVenta . "_" . time() . "_" . substr(md5($nombreSinExtension), 0, 8) . "." . $extension;

                        $ruta_destino = $uploads_dir . $nuevo_nombre;

                        if (move_uploaded_file($file_tmp, $ruta_destino)) {

                            // Nombre legible automático
                            $nombreLegible = ucfirst(str_replace('_', ' ', $campoNombre));

                            $datosArchivo = [
                                "id_venta" => $idVenta,                               // ← cambiado
                                "nombre" => $nombreLegible,
                                "nombre_archivo" => $nuevo_nombre,
                                "ruta" => $ruta_destino,
                                "tipo" => $file_type,
                                "campo_origen" => $campoNombre,
                                "tipo_ruta" => "web",
                                "fecha" => $fechaFormateada
                            ];

                            clienteModel::subirArchivosFormClientes($datosArchivo, "archivos");
                        } else {
                            error_log("Error al mover archivo: $file_name");
                        }
                    } else {
                        error_log("Tipo de archivo no permitido: $file_type ($file_name)");
                    }
                }
            }
        }

        $datosPago = [
            "id_venta" => $idVenta,
            "id_asesor" => $_POST["id_asesor"],
            "valor" => $_POST["abono_inicial"],
            "metodo_pago" => $_POST["metodo_pago"],
            "estado" => "aprobado",
            "fecha_pago" => $_POST["fecha_pago"],
            "fecha" => $fechaFormateada
        ];


        $respuestaPago = clienteModel::insertarPagoVenta($datosPago, "pagos");

        $actualizarEstadoEnlace = clienteModel::actualizarEstadoEnlace($_POST["codigo_seguimiento"], 2, "enlace_temporal");

        $wpp_cliente = !empty($_POST["paso1_whatsapp"] ?? "")
            ? $_POST["paso1_whatsapp"]
            : ($_POST["paso1_celular"] ?? "");
        
        require_once "functions/wpp.php";

        enviarWhatsAppZenviaTemplate(
            $wpp_cliente,
            "89d67798-3cd8-442a-a621-9caf1c9b5e65",
            [
                "Nombre" => $_POST["paso1_nombres"]
            ]
        );


       echo '<script>
    window.location = "' . BASE_URL . 'registro-exitoso?ok=1&codigo=' . urlencode($_POST["codigo_seguimiento"]) . '";
    </script>';
    exit();


        return;
    }
    public static function crearCliente($data)
    {
        // Buscar cliente por correo o cédula
        $cliente = clienteModel::buscarPorDocumentoOCorreo(
            $data['cedula'],
            $data['correo']
        );

        if ($cliente) {
            return $cliente['id'];
        }

        return clienteModel::crearCliente([
            "nombre" => $data['nombres'] ?? null,
            "apellido" => $data['apellidos'] ?? null,
            "cedula" => $data['cedula'] ?? null,
            "telefono" => $data['celular'] ?? null,
            "wpp" => $data['whatsapp'] ?? null,
            "correo" => $data['correo'] ?? null,
        ]);
    }

    // ACTUALIZAR CLIENTE - FORMULARIO
    public function actClienteForm()
    {
        if (!isset($_POST["formRegistroCliente"]))
            return;


        // Verificar si existe el campo que indica el paso 1
        if (!isset($_POST['paso1_nombres'])) {
            $this->mostrarAlerta("error", "Datos incompletos.", "formulario");
            return;
        }

        $tzBogota = new DateTimeZone('America/Bogota');
        $fechaBogota = new DateTime('now', $tzBogota);
        $fechaHoy = new DateTime('now', $tzBogota);
        $fechaFormateada = $fechaBogota->format('Y-m-d H:i:s');

        // Carpeta donde se guardarán los archivos
        $uploads_dir = 'uploads/forms/';
        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        // ============================================
        // PASO 1: DATOS PERSONALES (siempre vienen con prefijo 'paso1_')
        // ============================================
        $datosCliente = [
            "id" => $_POST["id_cliente"],
            "nombre" => htmlspecialchars($_POST["paso1_nombres"] ?? ""),
            "apellido" => htmlspecialchars($_POST["paso1_apellidos"] ?? ""),
            "cedula" => htmlspecialchars($_POST["paso1_cedula"] ?? ""),
            "telefono" => htmlspecialchars($_POST["paso1_celular"] ?? ""),
            "wpp" => htmlspecialchars($_POST["paso1_whatsapp"] ?? ""),
            "correo" => htmlspecialchars($_POST["paso1_correo"] ?? ""),
            "tomo_servicio" => 1
        ];

        // Validar datos mínimos del cliente
        if (
            empty($datosCliente["nombre"]) || empty($datosCliente["cedula"]) ||
            empty($datosCliente["telefono"]) || empty($datosCliente["correo"])
        ) {
            $this->mostrarAlerta("error", "Faltan datos personales obligatorios.", "formulario");
            return;
        }

        $respuestaCliente = clienteModel::actulizarCliebteFormWeb($datosCliente, "clientes");

        if (!is_array($respuestaCliente) || $respuestaCliente[0] !== "success") {
            $this->mostrarAlerta("error", "Error al registrar cliente.", "formulario");
            return;
        }


        // ============================================
        // PASO 2: DATOS DINÁMICOS DEL FORMULARIO
        // ============================================
        // Separar campos de texto y archivos

        $camposArchivos = [];
        $camposTexto = [];

        // 1. Campos ocultos del sistema que NO deben guardarse
        $excluirCamposSistema = [
            'btnRegistroCliente',
            'formRegistroCliente',
            'id_venta',
            'id_cliente',
            'codigo_seguimiento'
        ];

        // 2. Prefijos que queremos excluir (Paso 1)
        $excluirPrefijos = [
            'paso1_',   // si los campos del paso 1 tienen prefijo
        ];

        // 3. Campos específicos del Paso 1 (sin prefijo)
        $excluirPaso1Directos = [
            'nombres',
            'apellidos',
            'correo',
            'celular',
            'whatsapp',
            'cedula',
            'metodo_pago',
            'fecha_pago'
        ];

        foreach ($_POST as $key => $value) {

            // A. Excluir campos ocultos del sistema
            if (in_array($key, $excluirCamposSistema)) {
                continue;
            }

            // B. Excluir por prefijo (paso1_)
            foreach ($excluirPrefijos as $prefijo) {
                if (strpos($key, $prefijo) === 0) {
                    continue 2;
                }
            }

            // C. Excluir campos del paso 1 sin prefijo
            if (in_array($key, $excluirPaso1Directos)) {
                continue;
            }

            // D. Guardar el resto
            $camposTexto[$key] = htmlspecialchars($value);
        }



        // Procesar archivos del formulario
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                // Excluir archivos del paso 1 si los hubiera
                if (strpos($key, 'paso1_') === 0) {
                    continue;
                }

                if ($file['error'] === UPLOAD_ERR_OK) {
                    $camposArchivos[$key] = $file;
                } else if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                    // Error en la subida (no es "no file")
                    $this->mostrarAlerta("error", "Error al subir archivo: " . $key, "formulario");
                    return;
                }
            }
        }

        $idVenta = $_POST["id_venta"];

        $datosVenta = [
            "campos_form" => json_encode($camposTexto, JSON_UNESCAPED_UNICODE),
            "id" => $idVenta
        ];

        $respuestaVenta = clienteModel::actCamposformVenta($datosVenta, "ventas");

        // ============================================
        // PROCESAR ARCHIVOS DEL PASO 2
        // ============================================
        if (!empty($camposArchivos)) {

            foreach ($camposArchivos as $campoNombre => $archivo) {

                if ($archivo['error'] === UPLOAD_ERR_OK) {

                    $file_tmp = $archivo['tmp_name'];
                    $file_name = basename($archivo['name']);
                    $file_type = mime_content_type($file_tmp);

                    // Tipos permitidos
                    $tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

                    if (in_array($file_type, $tiposPermitidos)) {

                        // Crear nombre seguro
                        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                        $nombreSinEspacios = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file_name);
                        $nombreSinExtension = pathinfo($nombreSinEspacios, PATHINFO_FILENAME);

                        $nuevo_nombre =
                            $idVenta . "_" . time() . "_" . substr(md5($nombreSinExtension), 0, 8) . "." . $extension;

                        $ruta_destino = $uploads_dir . $nuevo_nombre;

                        if (move_uploaded_file($file_tmp, $ruta_destino)) {

                            // Nombre legible automático
                            $nombreLegible = ucfirst(str_replace('_', ' ', $campoNombre));

                            $datosArchivo = [
                                "id_venta" => $idVenta,                               // ← cambiado
                                "nombre" => $nombreLegible,
                                "nombre_archivo" => $nuevo_nombre,
                                "ruta" => $ruta_destino,
                                "tipo" => $file_type,
                                "campo_origen" => $campoNombre,
                                "tipo_ruta" => "web",
                                "fecha" => $fechaFormateada
                            ];

                            clienteModel::subirArchivosFormClientes($datosArchivo, "archivos");
                        } else {
                            error_log("Error al mover archivo: $file_name");
                        }
                    } else {
                        error_log("Tipo de archivo no permitido: $file_type ($file_name)");
                    }
                }
            }
        }

        $actualizarEstadoEnlace = clienteModel::actualizarEstadoEnlace($_POST["codigo_seguimiento"], 2, "enlace_temporal");


        include_once "functions/correos.php";

        $subject = 'Registro realizado correctamente';
        $codigo_seguimiento = $_POST["codigo_seguimiento"];
        $nombre_cliente = $_POST["paso1_nombres"];

        $mensaje = '
                <html>
                <body
                    style="
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    background-color: #090830;
                    color: #fff;
                    "
                >
                    <div style="text-align: center; margin-bottom: 20px; padding-top: 2rem">
                    <img
                        src="https://apostillasylegalizaciones.com/views/assets//img/logo-navidad.png"
                        alt="Logo"
                        style="max-width: 200px"
                    />
                    </div>

                    <div style="width: 100%; max-width: 320px; margin: 0 auto">
                    <h2 style="text-align: center;">Hola, ' . $nombre_cliente . '</h2>

                    <p style="font-size: 17px;">
                        Haz realizado el registro del formulario correctamente.
                    </p>

                    <p
                        style="
                        font-size: 20px;
                        color: #090830;
                        font-weight: bold;
                        padding: 10px;
                        background-color: #fff;
                        border-radius: 10px;
                        text-align: center;
                        "
                    >
                        Código de seguimiento: ' . $codigo_seguimiento . '
                    </p>

                    <p style="font-size: 17px;">Utiliza este código para hacer seguimiento a tu caso con nuestros asesores.</p>

                    <p style="text-align: center; margin: 25px 0">
                        <a
                        href="https://api.whatsapp.com/send/?phone=573177578395"
                        style="
                            background-color: #11a447;
                            color: white;
                            padding: 12px 24px;
                            text-decoration: none;
                            border-radius: 5px;
                            font-weight: bold;
                        "
                        >
                        Contactar por WhatsApp
                        </a>
                    </p>
                    </div>

                    <hr style="margin: 30px 0" />

                    <div style="padding-bottom: 2rem;">
                    <p style="text-align: center; font-size: 12px; color: #fff">
                        Este correo fue enviado desde
                        <a href="https://apostillasylegalizaciones.com/" style="color: #fff"
                        >apostillasylegalizaciones.com</a
                        ><br />
                        <img
                        src="https://apostillasylegalizaciones.com/views/assets/img/logo-navidad.png"
                        alt="Logo"
                        style="max-width: 100px; margin-top: 10px"
                        />
                    </p>
                    </div>
                </body>
                </html>
                ';
        enviarCorreo($_POST["paso1_correo"], $subject, $mensaje);

        echo '<script>
    window.location = "' . BASE_URL . 'registro-exitoso?ok=1&codigo=' . urlencode($_POST["codigo_seguimiento"]) . '";
</script>';
        exit();

        return;
    }
        private function generarCodigoLinkVenta($id_asesor, $nombre_asesor, $longitudAleatoria = 6)
    {
        // Obtener la primera letra del primer nombre en mayúscula
        $nombreLimpio = preg_replace('/[^a-zA-Z\s]/', '', $nombre_asesor); // Remover números y caracteres especiales
        $partesNombre = explode(' ', trim($nombreLimpio));

        if (empty($partesNombre[0])) {
            $inicial = 'A'; // Letra por defecto si no hay nombre válido
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

    

}
