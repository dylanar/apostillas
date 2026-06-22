<?php
include_once "functions/pipes.php";
$encoded = $_GET['data'] ?? '';

$json = urldecode($encoded);
$data = json_decode(base64_decode($json), true);

$consultaPaisesS = model::consultaModel("paises_servicio");
$step = 2;
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
                Hola <strong><?= ucfirst(strtolower($data['nombres'])); ?></strong> 👋
            </h2>

            <h5 class="mb-5">
                Selecciona el país donde fue emitido tu documento
                <br>
                <small class="text-info">(Si tu documento es un diploma español, debes seleccionar España)</small>
            </h5>

            <!-- SERVICIOS -->
            <div class="d-flex flex-wrap justify-content-center">

                <?php foreach ($consultaPaisesS as $pais):
                    $nombre = $pais["nombre"];
                    $BASE_BACK = "https://crm.apostillasylegalizaciones.com/";
                    $imagen = $BASE_BACK . $pais["imagen"];
                    ?>

                    <div class="item_pais_servicio" data-id="<?= $pais['id']; ?>"
                        onclick="seleccionarPais(this, '<?= BASE_URL ?>')">

                        <img src="<?= $imagen; ?>" alt="Imagen de <?= $nombre; ?>">
                        <p><?= $nombre; ?></p>
                    </div>



                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<div id="loadingApostilla" class="loading-overlay">
    <div class="loading-box">
        <div class="spinner"></div>
        <p id="loadingText">Procesando tu información…</p>
    </div>
</div>


<script>
    // Datos que vienen del formulario inicial
    const datosBase = <?= json_encode($data, JSON_UNESCAPED_UNICODE); ?>;
</script>