<?php
include_once "functions/pipes.php";
$encoded = $_GET['data'] ?? '';

$json = urldecode($encoded);
$data = json_decode(base64_decode($json), true);

$consultaPaisesS = model::consultaModel("paises_servicio");
$step = 4;
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

            <h5 class="mb-4">
                Sube tus documentos para revisión previa
            </h5>

            <p class="mb-5">
                Adjunta uno o varios documentos para que nuestro equipo valide la información antes de continuar.
                <br>
                <strong>Este paso es solo de verificación</strong>, tus archivos no se procesan aún.
            </p>

            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div id="dropzoneFake" class="border rounded p-4 mb-4 text-center"
                        style="border-style: dashed; cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                        <p class="mb-1 font-weight-bold">Arrastra tus documentos aquí</p>
                        <p class="small mb-0">o haz clic para seleccionarlos</p>
                        <input type="file" id="filesInput" multiple class="d-none">
                    </div>

                    <div id="listaArchivos" class="text-left mb-4"></div>

                    <button id="btnEnviarRevision" class="btn btn-white btn-block d-none">
                        Enviar a revisión
                    </button>

                    <!-- Loading -->
                    <div id="loadingRevision" class="d-none mt-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Enviando documentos a revisión...</p>
                    </div>

                </div>
            </div>
        </div>


    </div>



</section>

<script>
    const base_url = "<?= BASE_URL ?>";
    const datosBase = <?= json_encode($data, JSON_UNESCAPED_UNICODE); ?>;

    const dropzone = document.getElementById('dropzoneFake');
    const inputFiles = document.getElementById('filesInput');
    const lista = document.getElementById('listaArchivos');
    const btnEnviar = document.getElementById('btnEnviarRevision');
    const loading = document.getElementById('loadingRevision');

    let archivos = [];

    // Click en zona
    dropzone.addEventListener('click', () => inputFiles.click());

    // Captura archivos
    inputFiles.addEventListener('change', manejarArchivos);

    function manejarArchivos(e) {
        archivos = Array.from(e.target.files);
        lista.innerHTML = '';

        archivos.forEach(file => {
            lista.innerHTML += `
            <div class="border rounded p-2 mb-2 small">
                <i class="fas fa-file-alt text-secondary"></i>
                ${file.name}
            </div>
        `;
        });

        if (archivos.length > 0) {
            btnEnviar.classList.remove('d-none');
        }
    }

    // Enviar a revisión (fake)
    btnEnviar.addEventListener('click', function () {

        btnEnviar.classList.add('d-none');
        loading.classList.remove('d-none');

        setTimeout(() => {

            const jsonString = JSON.stringify(datosBase);
            const encoded = btoa(unescape(encodeURIComponent(jsonString)));

            window.location.href = base_url + `pagar-servicio/?data=${encoded}`;

        }, 2500); // loading de 2.5 segundos
    });
</script>