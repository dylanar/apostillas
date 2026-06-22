<?php if (!isset($_GET["ok"]) || empty($_GET["codigo"])): ?>
    <div class="container py-5 text-center">
        <h4>Acceso no válido</h4>
        <a href="<?= BASE_URL ?>" class="btn btn-dark mt-3">Volver al inicio</a>
    </div>
<?php return; endif; ?>

<?php
require_once "functions/notificacionAsesor.php";

$codigo = $_GET["codigo"];
$datos  = clienteModel::obtenerDatosPorCodigo($codigo);

$linkWhatsapp = null;
if ($datos) {
    $camposForm = json_decode($datos['campos_form'] ?? '{}', true);

    $mensaje = generarMensajeNotificacionAsesor([
        'servicio'         => obtenerNombreServicio($datos['id_servicio']),
        'nombre'           => trim($datos['nombre'] . ' ' . $datos['apellido']),
        'documento'        => $datos['cedula'],
        'correo'           => $datos['correo'],
        'numero_solicitud' => $datos['id_venta'],
        'metodo_pago'      => $camposForm['metodo_pago'] ?? null,
        'fecha_entrega'    => $datos['fecha_entrega'],
        'saldo_pendiente'  => ($datos['precio'] ?? 0) - ($datos['abono'] ?? 0),
    ]);

    $linkWhatsapp = generarLinkWhatsapp(WHATSAPP_VENTAS, $mensaje);
}
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-success text-white text-center py-4">
                    <i class="fa fa-check-circle fa-4x mb-3"></i>
                    <h3 class="fw-bold mb-0">¡Registro exitoso!</h3>
                </div>
                <div class="card-body p-5 text-center">
                    <h5 class="fw-bold mb-3">
                        Tu información ha sido registrada correctamente
                    </h5>
                    <p class="mt-4">
                        Excelente! Uno de nuestros asesores se pondrá en contacto contigo en breve.
                    </p>

                    <?php if ($linkWhatsapp): ?>
                        <a href="<?= htmlspecialchars($linkWhatsapp) ?>" target="_blank" rel="noopener"
                           class="btn btn-success px-4 rounded-pill mb-2">
                            <i class="fa-brands fa-whatsapp me-2"></i>
                            ¡Notifica a tu asesor!
                        </a>
                        <div class="form-text mb-3">
                            Envíale tus datos por WhatsApp y agiliza tu trámite
                        </div>
                    <?php endif; ?>

                    <hr class="my-4">
                    <a href="/" class="btn btn-dark px-4 rounded-pill">
                        <i class="fa fa-home me-2"></i>
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>