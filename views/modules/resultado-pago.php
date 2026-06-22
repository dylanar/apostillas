<?php
include_once "functions/pipes.php";
$orderID = $_GET["bold-order-id"];
$status = $_GET["bold-tx-status"];

$consultaOrden = model::consultaDatoModel("ventas", "order_id", $orderID);

$id_venta = $consultaOrden["id"];

$consultaCliente = model::consultaDatoModel("clientes", "id", $consultaOrden["id_cliente"]);

$correo_cliente = $consultaCliente["correo"];
$nombre_cliente = $consultaCliente["nombre"] . " " . $consultaCliente["apellido"];
$wpp_cliente = $consultaCliente["wpp"];

//SERVICIO
$consultaServicio = model::consultaDatoModel("servicios", "id", $consultaOrden["id_servicio"]);

$pago = model::consultaDatoModel("pagos", "id_venta", $consultaOrden["id"]);

$id_pago = $pago["id"];

$ctr = new ventaController();
$ctr->actualizarEstadoVenta($id_venta, $status, $consultaCliente["id"], $correo_cliente, $nombre_cliente, $wpp_cliente, $consultaServicio["titulo"] ,$consultaOrden["precio"], $orderID, $id_pago);


$icon = '';
$title = '';
$message = '';
$alert = '';
$buttonText = 'Finalizar Pago';
$buttonLink = 'home';

switch ($status) {

    case 'processing':
        $icon = 'fa-spinner fa-spin';
        $title = 'Transacción en proceso';
        $message = 'Tu transacción se está procesando. Esto puede tardar unos minutos. Te notificaremos por correo y WhatsApp cuando finalice.';
        $alert = 'info';
        $buttonText = 'Volver al inicio';
        break;

    case 'pending': // PSE
        $icon = 'fa-clock';
        $title = 'Transacción pendiente';
        $message = 'Tu pago está pendiente de confirmación por parte del banco. Te avisaremos por correo y WhatsApp cuando tengamos respuesta.';
        $alert = 'warning';
        $buttonText = 'Entendido';
        break;

    case 'approved':
        $icon = 'fa-check-circle';
        $title = '¡Transacción aprobada!';
        $message = 'Tu transacción fue aprobada exitosamente. La información será enviada a tu correo y WhatsApp. Un asesor se pondrá en contacto contigo en breve.';
        $alert = 'success';
        break;

    case 'rejected':
        $icon = 'fa-times-circle';
        $title = 'Transacción rechazada';
        $message = 'Tu transacción fue rechazada. Te enviaremos la información detallada por correo y WhatsApp.';
        $alert = 'danger';
        break;

    case 'failed':
        $icon = 'fa-exclamation-triangle';
        $title = 'Transacción fallida';
        $message = 'Ocurrió un error durante el proceso de pago. Te enviaremos la información por correo y WhatsApp.';
        $alert = 'danger';
        break;

    case 'voided':
        $icon = 'fa-ban';
        $title = 'Transacción anulada';
        $message = 'La transacción fue anulada correctamente. Recibirás la información por correo y WhatsApp.';
        $alert = 'secondary';
        break;

    default:
        $icon = 'fa-info-circle';
        $title = 'Estado desconocido';
        $message = 'No se pudo determinar el estado de la transacción.';
        $alert = 'secondary';
}
?>

<style>
    .status-card {
        max-width: 600px;
        margin: auto;
        margin-top: 10vh;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    .status-icon {
        font-size: 4rem;
    }
</style>

<div class="container mt-4">
    <div class="card status-card text-center">
        <div class="card-body">

            <div class="text-<?php echo $alert; ?> mb-3">
                <i class="fas <?php echo $icon; ?> status-icon"></i>
            </div>

            <h4 class="font-weight-bold mb-3">
                <span class="text-capitalize mb-1">
                    <?= $consultaCliente["nombre"]; ?>
                </span> <br>
                <?php echo $title; ?>
            </h4>

            <p class="text-muted mb-4">
                <?php echo $message; ?>
            </p>

            <hr>

            <h5 class="font-weight-bold mb-3">
                Resumen de tu compra
            </h5>

            <div class="mb-2">
                <strong>Servicio</strong>
                <p class="mb-1">
                    <?= $consultaServicio["titulo"]; ?>
                </p>
            </div>

            <div class="mb-3">
                <strong>Descripción</strong>
                <p class="text-muted mb-0">
                    <?= $consultaServicio["descripcion"]; ?>
                </p>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center">
                <span class="font-weight-bold">
                    Valor de la compra
                </span>
                <span class="h5 text-primary font-weight-bold mb-0">
                    <?= formatoPesosColombianos($consultaOrden["precio"]); ?>
                </span>
            </div>

            <a href="<?php echo $buttonLink; ?>" class="btn btn-primary btn-lg btn-block mt-2">
                <?php echo $buttonText; ?>
            </a>

        </div>
    </div>
</div>