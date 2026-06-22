<?php
if (isset($_GET["param1"])) {

    $codigo = $_GET["param1"] ?? null;

    if (!$codigo) {
        echo '<div class="alert alert-danger">Código no proporcionado</div>';
        exit;
    }

    $info = model::consultaDatoModel("enlace_temporal", "codigo", $codigo);

    if (!$info || empty($info["data"])) {
        echo '<div class="alert alert-danger">Error: Código inválido</div>';
        exit;
    }

    $datos = json_decode($info["data"], true);

    if (!isset($datos["id_venta"], $datos["archivos"])) {
        echo '<div class="alert alert-danger">Error: Información incompleta</div>';
        exit;
    }

    $id_venta = (int) $datos["id_venta"];
    $archivos = $datos["archivos"];

    $venta = model::consultaDatoModel("ventas", "id", $id_venta);
    if (!$venta) {
        echo '<div class="alert alert-danger">Error: No se encontró la venta</div>';
        exit;
    }

    $servicio = model::consultaDatoModel("servicios", "id", $venta["id_servicio"]);
    $nombre_servicio = $servicio["titulo"];

    $cliente = model::consultaDatoModel("clientes", "id", $venta["id_cliente"]);
    $nombre_cliente = $cliente["nombre"] . " " . $cliente["apellido"];
    ?>


    <div class="container py-4">
        <!-- Saludo simple -->
        <div class="mb-4">
            <h3>¡Hola, <?php echo htmlspecialchars($nombre_cliente); ?>!</h3>
            <p class="text-muted">Tus documentos del servicio
                <strong><?php echo htmlspecialchars($nombre_servicio); ?></strong> están listos para descargar.
            </p>
        </div>

        <!-- Documentos -->
        <?php if (empty($archivos)): ?>
            <div class="alert alert-warning">
                No hay documentos disponibles.
            </div>
        <?php else: ?>
            <div class="mb-4">
                <h5>Documentos disponibles:</h5>
                <ul class="list-group">
                    <?php foreach ($archivos as $archivo): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($archivo['nombre']); ?></strong>
                                </div>
                                <a href="<?php echo htmlspecialchars($archivo['ruta']); ?>" class="btn btn-success btn-sm"
                                    target="_blank">
                                    Descargar
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Botón de salir -->
        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL . 'documentos'; ?>" class="btn btn-secondary">
                Volver al inicio
            </a>
        </div>
    </div>
    <?php

} else {
    ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="card-title">Descarga de documentos</h3>
                            <p class="text-muted mt-2">
                                Ingresa el código que te asignó tu asesor o que recibiste por correo electrónico
                            </p>
                        </div>


                        <div class="form-group mb-4">
                            <label for="codigo_seguimiento" class="form-label fw-bold">
                                <i class="fa fa-key me-2"></i>Código
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa fa-qrcode"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg" id="codigo_seguimiento"
                                    name="codigo" required autocomplete="off" autofocus value="<?php if (isset($_GET["param1"])) {
                                        echo $_GET["param1"];
                                    } ?>">
                                <button class="btn btn-outline-secondary" type="button" id="btnPegarCodigo"
                                    title="Pegar código">
                                    <i class="fa fa-paste"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="fa fa-info-circle me-1"></i>
                                    El código suele tener letras y números. Ej: J7ABC123, M8XYZ456
                                </small>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" name="verificar_codigo">
                                <i class="fa fa-search me-2"></i>Verificar código
                            </button>
                            <a href="<?= BASE_URL; ?>ayuda-codigo" class="btn btn-link text-decoration-none">
                                <i class="fa fa-question-circle me-1"></i>¿No tienes o no recuerdas tu código?
                            </a>
                        </div>


                        <div class="mt-4 pt-3 border-top">
                            <div class="alert alert-light" role="alert">
                                <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>¿Dónde encuentro mi código?
                                </h6>
                                <ul class="mb-0 ps-3">
                                    <li>En el mensaje de WhatsApp de tu asesor</li>
                                    <li>Solicitándolo directamente a tu asesor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var btnVerificar = document.querySelector('button[name="verificar_codigo"]');
            var inputCodigo = document.getElementById('codigo_seguimiento');
            var btnPegar = document.getElementById('btnPegarCodigo');

            function redirigir() {
                var codigo = inputCodigo.value.trim();

                if (!codigo) {
                    alert('Por favor, ingresa un código de seguimiento');
                    inputCodigo.focus();
                    return;
                }

                window.location.href = '<?= BASE_URL; ?>documentos/' + encodeURIComponent(codigo);
            }

            // Evento click
            if (btnVerificar) {
                btnVerificar.addEventListener('click', redirigir);
            }

            // Evento Enter
            if (inputCodigo) {
                inputCodigo.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        redirigir();
                    }
                });
            }

            // Pegar código
            if (btnPegar) {
                btnPegar.addEventListener('click', function () {
                    if (navigator.clipboard) {
                        navigator.clipboard.readText()
                            .then(text => {
                                inputCodigo.value = text.trim();
                                inputCodigo.focus();
                            })
                            .catch(err => {
                                console.error('Error al pegar:', err);
                                inputCodigo.focus();
                            });
                    } else {
                        inputCodigo.focus();
                    }
                });
            }
        });
    </script>
    <?php
}
?>