<?php
include_once "functions/pipes.php";
$encoded = $_GET['data'] ?? '';

$json = urldecode($encoded);
$data = json_decode(base64_decode($json), true);

$pais = $data["id_pais_servicio"];

$consultaServicios = model::consultaDondeAndModel("servicios", "publico", 1, "id_pais_servicio", $pais);
$step = 3;


?>

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



    <div class="elegir-servicio">
        <div class="container text-center">

            <!-- ENCABEZADO -->
            <h2 class="mb-2">
                <strong><?= ucfirst(strtolower($data['nombres'])); ?></strong> 👋
            </h2>

            <h5 class="mb-5">
                Elige el servicio que necesitas y continúa tu proceso
            </h5>

            <!-- SERVICIOS -->
            <div class="row justify-content-center">

                <?php foreach ($consultaServicios as $servicio):
                    $titulo = $servicio["titulo"];
                    $descripcion = $servicio["descripcion"];
                    $dias = $servicio["fecha_entrega"];
                    $precio = formatoPesosColombianos($servicio["precio"]);
                    ?>

                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">

                            <div class="card-body d-flex flex-column">

                                <h5 class="font-weight-bold text-uppercase mb-2">
                                    <?= $titulo; ?>
                                </h5>

                                <p class="text-muted small mb-3">
                                    <?= $descripcion; ?>
                                </p>

                                <div class="mb-3">
                                    <p class="text-primary">
                                        Entrega en <?= $dias; ?> día<?= $dias > 1 ? 's' : ''; ?>
                                    </p>
                                </div>

                                <h4 class="font-weight-bold mb-4">
                                    <?= $precio; ?>
                                </h4>

                                <!-- BOTÓN SELECCIONAR -->
                                <button type="button" class="btn btn-outline-primary btn-block mt-auto seleccionar-servicio"
                                    data-id="<?= $servicio['id']; ?>">
                                    Seleccionar servicio
                                </button>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>


        </div>
    </div>
</section>

<div id="loadingApostilla" class="loading-overlay">
    <div class="loading-box">
        <div class="spinner"></div>
        <p id="loadingText">Procesando tu selección…</p>
    </div>
</div>

<script>
    const datosBase = <?= json_encode($data, JSON_UNESCAPED_UNICODE); ?>;
    const base_url = "<?= BASE_URL; ?>";

    const loading = document.getElementById("loadingApostilla");
    const loadingText = document.getElementById("loadingText");

    document.querySelectorAll('.seleccionar-servicio').forEach(btn => {

        btn.addEventListener('click', function () {

            const idServicio = this.dataset.id;

            if (!idServicio) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo identificar el servicio seleccionado."
                });
                return;
            }

            // Bloquear todos los botones para evitar doble clic
            document.querySelectorAll('.seleccionar-servicio').forEach(b => {
                b.disabled = true;
            });

            // Mostrar loading
            loadingText.textContent = "Preparando tu servicio…";
            loading.style.display = "flex";

            const dataFinal = {
                ...datosBase,
                id_servicio: idServicio
            };

            const jsonString = JSON.stringify(dataFinal);
            const encoded = btoa(unescape(encodeURIComponent(jsonString)));

            // Delay de 3 segundos
            setTimeout(() => {
                loadingText.textContent = "Redirigiéndote al siguiente paso…";
                window.location.href = base_url + `revision-documentos/?data=${encoded}`;
            }, 3000);

        });

    });
</script>