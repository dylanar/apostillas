<?php
include_once "functions/pipes.php";

$encoded = $_GET['data'] ?? '';
$json = urldecode($encoded);
$data = json_decode(base64_decode($json), true);


// Consultas
$id_servicio = $data['id_servicio'];
$id_pais = $data['id_pais_servicio'];

$servicio = model::consultaDatoModel("servicios", "id", $id_servicio);
$pais = model::consultaDatoModel("paises_servicio", "id", $id_pais);

// Datos servicio
$titulo = $servicio["titulo"];
$descripcion = $servicio["descripcion"];
$dias = $servicio["fecha_entrega"];
$precio = formatoPesosColombianos($servicio["precio"]);

// Precio sin formato para Bold
$montoBold = (int) $servicio["precio"]; // 30000

// Datos del cliente para Bold
$customerData = [
    "email" => $data["correo"] ?? "",
    "fullName" => trim(($data["nombres"] ?? "") . " " . ($data["apellidos"] ?? "")),
    "phone" => $data["celular"] ?? "",
    "dialCode" => "+57",
    "documentNumber" => $data["cedula"] ?? "",
    "documentType" => "CC"
];

// Convertir a JSON seguro
$customerDataJson = htmlspecialchars(json_encode($customerData, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');

// ID de orden simple (puedes cambiar la lógica)
$orderId = "APO-" . uniqid();

// Datos para el hash
$currency = "COP";
$boldSecretKey = "A5rwVQoaGJCzE5OklQH5ow";
// Cadena concatenada EXACTA
$cadenaIntegridad = $orderId . $montoBold . $currency . $boldSecretKey;

// Hash SHA256
$integritySignature = hash("sha256", $cadenaIntegridad);

$id_cliente = clienteController::crearCliente($data);
$id_venta = ventaController::crearVenta($id_cliente, $data, $servicio, $orderId);
$id_pago = pagoController::crearPago($id_venta, $montoBold);

$step = 5;
?>

<div id="contenidoPago" style="display:none;">
    <section class="form-web-apostillas py-5">


        <div class="wizard-container mb-5">
            <ul class="wizard-steps">

                <li class="wizard-step <?= $step >= 1 ? 'active' : ''; ?>">
                    <span>1</span>
                    <p>Datos</p>
                </li>

                <li class="wizard-step <?= $step >= 2 ? 'active' : ''; ?>">
                    <span>2</span>
                    <p>País</p>
                </li>

                <li class="wizard-step <?= $step >= 3 ? 'active' : ''; ?>">
                    <span>3</span>
                    <p>Servicio</p>
                </li>

                <li class="wizard-step <?= $step >= 4 ? 'active' : ''; ?>">
                    <span>4</span>
                    <p>Documentos</p>
                </li>

                <li class="wizard-step <?= $step >= 5 ? 'active' : ''; ?>">
                    <span>5</span>
                    <p>Pago</p>
                </li>

            </ul>
        </div>

        <div class="container">

            <!-- ENCABEZADO -->
            <div class="text-center mb-5">
                <h2 class="mb-2">
                    ✅ Documentos revisados con éxito
                </h2>

                <h5>
                    <strong><?= ucfirst(strtolower($data['nombres'])); ?></strong>, ya puedes continuar con el pago
                    para iniciar tu trámite.
                </h5>
            </div>

            <div class="row">

                <!-- RESUMEN DEL SERVICIO -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">

                        <div class="card-body text-left">
                            <h4> Resumen del servicio</h4>

                            <p><strong>Servicio:</strong><br><?= $titulo; ?></p>

                            <p><strong>Descripción:</strong><br>
                                <span class="text-muted"><?= $descripcion; ?></span>
                            </p>

                            <p><strong>País del documento:</strong><br>
                                <?= $pais['nombre']; ?>
                            </p>

                            <p><strong>Tiempo estimado:</strong><br>
                                <?= $dias; ?> día<?= $dias > 1 ? 's' : ''; ?>
                            </p>

                            <hr>

                            <h4 class="text-primary text-center">
                                Total a pagar:<br>
                                <strong><?= $precio; ?></strong>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- DATOS DEL CLIENTE -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h4>Datos del cliente</h4>
                            <form>
                                <div class="row mb-2">
                                    <div class="form-group col-md-6">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($data['nombres'] ?? ''); ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($data['apellidos'] ?? ''); ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="form-group col-12">
                                        <label>Número de Cédula</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($data['cedula'] ?? ''); ?>" disabled>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="form-group col-md-6">
                                        <label>Celular</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($data['celular'] ?? ''); ?>" disabled>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>WhatsApp</label>
                                        <input type="text" class="form-control"
                                            value="<?= htmlspecialchars($data['whatsapp'] ?? ''); ?>" disabled>
                                    </div>
                                </div>


                                <div class="form-group mb-2">
                                    <label>Correo electrónico</label>
                                    <input type="email" class="form-control"
                                        value="<?= htmlspecialchars($data['correo'] ?? ''); ?>" required disabled>
                                </div>

                                <div class="form-group form-check mt-3 mb-3">
                                    <label for="terminos">
                                        Al pagar aceptas los <a href="">términos y condiciones del servicio</a>
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <script src="https://bold.co/library/ui-kit.js"></script>

                                    <script data-bold-button data-bold-button="light-L"
                                        data-api-key="ifokPK6fJ9hqr4qw01K6CXfczaPyRzbh9q3PaTa5WoY"
                                        data-order-id="<?= $orderId; ?>" data-currency="COP"
                                        data-amount="<?= $montoBold; ?>"
                                        data-integrity-signature="<?= $integritySignature; ?>"
                                        data-description="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>"
                                        data-redirection-url="https://apostillasylegealizaciones.com/resultado-pago"
                                        data-customer-data='<?= $customerDataJson; ?>' data-render-mode="embedded">
                                        </script>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>


<div id="loadingPago" class="loading-pago">
    <section class="form-web-apostillas">
        <div class="loading-box" style="padding-top: 4rem;">
            <div class="spinner"></div>
            <h4 style="margin-top: 2rem;">Preparando tu pago seguro…</h4>
            <p style="color: #fff !important;">Estamos validando la información para continuar.</p>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            document.getElementById("loadingPago").style.display = "none";
            document.getElementById("contenidoPago").style.display = "block";
        }, 3000); // 3 segundos
    });
</script>