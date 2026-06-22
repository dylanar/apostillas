<?php

if (isset($_GET["param1"])) {
    $codigo =  $_GET["param1"];

   ?>
    <script>
        window.location.href = "<?=  BASE_URL ?>formulario/<?=  $codigo; ?>";
    </script>
   <?php
} else {

    $ctr = new clienteController();
    $ctr->verificarCodigoRegistroCliente();

?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="card-title">Registro de Cliente</h3>
                            <p class="text-muted mt-2">
                                Ingresa el código que te asignó tu asesor o que recibiste por correo electrónico
                            </p>
                        </div>

                        <form method="POST" id="formCodigo">
                            <div class="form-group mb-4">
                                <label for="codigo_seguimiento" class="form-label fw-bold">
                                    <i class="fa fa-key me-2"></i>Código
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa fa-qrcode"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control form-control-lg"
                                        id="codigo_seguimiento"
                                        name="codigo"
                                        required
                                        autocomplete="off"
                                        autofocus
                                        value="<?php if (isset($_GET["param1"])) {
                                                    echo $_GET["param1"];
                                                } ?>">
                                    <button class="btn btn-outline-secondary" type="button" id="btnPegarCodigo" title="Pegar código">
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
                        </form>

                        <div class="mt-4 pt-3 border-top">
                            <div class="alert alert-light" role="alert">
                                <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>¿Dónde encuentro mi código?</h6>
                                <ul class="mb-0 ps-3">
                                    <li>En el correo electrónico de confirmación</li>
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

    <!-- Script para funcionalidades adicionales -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputCodigo = document.getElementById('codigo_seguimiento');
            const btnPegar = document.getElementById('btnPegarCodigo');
            const form = document.getElementById('formCodigo');

            // Botón para pegar desde portapapeles
            btnPegar.addEventListener('click', async function() {
                try {
                    const text = await navigator.clipboard.readText();
                    if (text.trim()) {
                        inputCodigo.value = text.trim();
                        // Seleccionar todo el texto para facilitar edición
                        inputCodigo.select();

                        // Mostrar notificación de éxito
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Código pegado correctamente'
                        });
                    }
                } catch (err) {
                    console.error('Error al pegar: ', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo acceder al portapapeles'
                    });
                }
            });

            // Validación en tiempo real
            inputCodigo.addEventListener('input', function() {
                // Convertir a mayúsculas automáticamente
                this.value = this.value.toUpperCase();

                // Remover espacios y caracteres especiales
                this.value = this.value.replace(/[^A-Z0-9]/g, '');
            });

            // Validación al enviar el formulario
            form.addEventListener('submit', function(e) {
                const codigo = inputCodigo.value.trim();

                if (!codigo) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Código requerido',
                        text: 'Por favor ingresa el código de seguimiento'
                    });
                    inputCodigo.focus();
                    return;
                }

                if (codigo.length < 6) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Código muy corto',
                        text: 'El código debe tener al menos 6 caracteres'
                    });
                    inputCodigo.focus();
                    inputCodigo.select();
                    return;
                }
            });

            // Enfocar el input automáticamente
            inputCodigo.focus();
        });
    </script>
<?php
}
?>