
<div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
    <div class="card shadow-sm p-4" style="max-width: 800px; width: 100%;">
        <div class="text-center mb-4">
            <i class="fas fa-users fs-1 text-primary"></i>
            <h4 class="mt-2">Gana comisión por referidos</h4>
            <p class="text-muted mb-0">
                Regístrate para obtener tu código de referido y empezar a ganar
            </p>
        </div>

        <form method="post">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Nombres</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-user"></i>
                </span>
                <input type="text" class="form-control" name="nombres" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Apellidos</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-id-card"></i>
                </span>
                <input type="text" class="form-control" name="apellidos" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Correo electrónico</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="email" class="form-control" name="correo" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Celular (WhatsApp)</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-phone"></i>
                </span>
                <input type="tel" class="form-control" name="celular" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Banco</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-building-columns"></i>
                </span>
                <input type="text" class="form-control" name="banco" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Número de cuenta</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-credit-card"></i>
                </span>
                <input type="text" class="form-control" name="numero_cuenta" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo de cuenta</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </span>
                <select class="form-control" name="tipo_cuenta" required>
                    <option value="">Selecciona</option>
                    <option value="ahorro">Ahorros</option>
                    <option value="corriente">Corriente</option>
                </select>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Cédula</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa-solid fa-id-card"></i>
                </span>
                <input type="text" class="form-control" name="cedula" required>
            </div>
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-gift"></i> Obtener mi código de referido
            </button>
        </div>

    </div>
</form>

        <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.85rem;">
            Al registrarte aceptas recibir información relacionada con el programa de referidos.
        </p>
    </div>
</div>


<!-- Modal Código de Referido -->
<div class="modal fade" id="modalCodigoReferido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-gift text-primary"></i> Tu código de referido
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-2">
                    Tu código de referido es:
                </p>

                <div class="border rounded p-3 mb-3 bg-light">
                    <h3 class="mb-0 text-primary fw-bold" id="codigoReferido">
                        <!-- Código dinámico -->
                    </h3>
                </div>

                <button class="btn btn-outline-primary mb-3 btn-sm" onclick="copiarCodigo()">
                    <i class="fas fa-copy"></i> Copiar código
                </button>

                <p class="text-muted small">
                    Comparte nuestro <strong>número y tu código</strong> <br>
                    con tus amigos para que inicien su trámite.
                    <br><br>
                    📞 WhatsApp / Llamada: <br>
                    <strong>+57 300 502 3755</strong>
                    <br>
                    <button class="btn btn-outline-primary mb-3 mt-3 btn-sm" onclick="copiarNumero()">
                        <i class="fas fa-copy"></i> Copiar número
                    </button>
                    <br><br>
                    Cada persona que inicie su proceso usando <br>
                    <strong>tu código genera una recompensa para ti</strong> ✅
                    <br><br>
                    ¡Gracias por recomendarnos!
                </p>


            </div>



            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const params = new URLSearchParams(window.location.search);
        const codigo = params.get('codigo');

        if (codigo && document.getElementById('modalCodigoReferido')) {
            document.getElementById('codigoReferido').innerText = codigo;

            const modal = new bootstrap.Modal(
                document.getElementById('modalCodigoReferido')
            );
            modal.show();
        }

    });

    function copiarCodigo() {
        const codigoTexto = document.getElementById('codigoReferido').innerText;

        navigator.clipboard.writeText(codigoTexto).then(() => {
            alert('Código copiado al portapapeles');
        });
    }
    
    function copiarNumero() {
        const codigoTexto = "573005023755";

        navigator.clipboard.writeText(codigoTexto).then(() => {
            alert('Número copiado al portapapeles');
        });
    }


</script>

<?php
$registro = new referidosController();
$registro->registrar();

?>