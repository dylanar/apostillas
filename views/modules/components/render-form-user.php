<?php
$crt = new clienteController();
$crt->crearClienteForm();
$crt->actClienteForm();
?>
<!-- Cargar librerías específicas para el selector de teléfono -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<style>

    #celular,
    #whatsapp {
        padding-left: 90px !important;
    }

    .iti {
        width: 100%;
    }

    .iti__country-list {
        z-index: 2000 !important;
    }
</style>
<div class="container mt-4">
    <div class="formulario_render">
        <!-- Indicador de pasos -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3">
                <div class="steps">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Datos Personales</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Documentación</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 1: Datos Personales -->
        <div class="paso paso-1">
            <div class="card shadow">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fa fa-user-plus me-2"></i>Datos Personales
                    </h3>
                    <span class="badge bg-light text-primary fs-6">Paso 1 de 2</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-primay mb-4">
                        <i class="fa fa-info-primary me-2"></i>
                        Complete sus datos personales. Todos los campos marcados con <span class="text-danger">*</span>
                        son obligatorios.
                    </div>

                    <form id="formPaso1">
                        <input type="hidden" name="codigo_seguimiento" value="<?= $codigo ?? ''; ?>">

                        <div class="row">
                            <!-- Nombres -->
                            <div class="col-md-6 mb-3">
                                <label for="nombres" class="form-label">
                                    <i class="fa fa-user me-1"></i> Nombres <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="nombres" name="nombres"
                                    placeholder="Ej: María José" required autocomplete="given-name" autofocus
                                    value="<?= $cliente["nombre"]; ?>">
                                <div class="form-text">
                                    Ingrese sus nombres completos
                                </div>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">
                                    <i class="fa fa-user me-1"></i> Apellidos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos"
                                    placeholder="Ej: González Pérez" required autocomplete="family-name"
                                    value="<?= $cliente["apellido"]; ?>">
                                <div class="form-text">
                                    Ingrese sus apellidos completos
                                </div>
                            </div>
                        </div>

                        <!-- Correo electrónico -->
                        <div class="mb-3">
                            <label for="correo" class="form-label">
                                <i class="fa fa-envelope me-1"></i> Correo electrónico <span
                                    class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-at"></i>
                                </span>
                                <input type="email" class="form-control" id="correo" name="correo"
                                    placeholder="ejemplo@correo.com" required value="<?= $cliente["correo"]; ?>"
                                    autocomplete="email">
                            </div>
                            <div class="form-text">
                                Ingrese un correo electrónico válido para notificaciones
                            </div>
                        </div>

                        <div class="row">
                    <!-- Celular -->
                    <div class="col-md-6 mb-3">
                        <label for="celular" class="form-label">
                            <i class="fa fa-mobile-alt me-1"></i> Celular <span class="text-danger">*</span>
                        </label>

                        <input 
                            type="tel" 
                            class="form-control" 
                            id="celular" 
                            name="celular"
                            placeholder="Ingrese su número"
                            required
                            value="<?= $cliente["telefono"]; ?>" 
                            autocomplete="tel">

                        <div class="form-text">
                            Incluya su número con el código de país
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp" class="form-label">
                            <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp (opcional)
                        </label>

                        <input 
                            type="tel" 
                            class="form-control" 
                            id="whatsapp" 
                            name="whatsapp"
                            placeholder="Ingrese su WhatsApp"
                            value="<?= $cliente["wpp"]; ?>" 
                            autocomplete="tel">

                        <div class="form-text">
                            Si es diferente al celular
                        </div>
                    </div>
                </div>

                        <!-- Número de cédula -->
                        <div class="mb-4">
                            <label for="cedula" class="form-label">
                                <i class="fa fa-id-card me-1"></i> Número de cédula <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-address-card"></i>
                                </span>
                                <input type="text" class="form-control" id="cedula" name="cedula"
                                    placeholder="1234567890" required pattern="[0-9]{6,12}" maxlength="12"
                                    value="<?= $cliente["cedula"]; ?>" autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" id="btnInfoCedula"
                                    title="Información">
                                    <i class="fa fa-info-circle"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Ingrese su número de cédula sin puntos ni comas
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="<?= BASE_URL; ?>registro" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="button" class="btn btn-primary px-4" id="btnSiguientePaso1">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Paso 2: Documentación (inicialmente oculto)  -->
        <div class="paso paso-2" style="display: none;">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fa fa-file-alt me-2"></i>Documentación Requerida
                    </h3>
                    <span class="badge bg-light text-primary fs-6">Paso 2 de 2</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary mb-4">
                        <i class="fa fa-check-circle me-2"></i>
                        Complete la siguiente documentación requerida para completar su tramite.
                    </div>

                    <form id="formPaso2" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="formRegistroCliente" value="formRegistroCliente">
                        <input type="hidden" name="codigo_seguimiento" value="<?= $codigo ?? ''; ?>">
                        <input type="hidden" name="id_servicio" value="<?= $id_servicio ?? ''; ?>">
                        <input type="hidden" name="id_cliente" value="<?= $id_cliente ?? ''; ?>">
                        <input type="hidden" name="id_asesor" value="<?= $id_asesor ?? ''; ?>">
                        <input type="hidden" name="cantidad_doc" value="<?= $cantidad_doc ?? ''; ?>">
                        <input type="hidden" name="abono_inicial" value="<?= $abono_inicial ?? ''; ?>">
                        <input type="hidden" name="precio" value="<?= $precio ?? ''; ?>">
                        <input type="hidden" name="nombre_asesor" value="<?= $nombre_asesor ?? ''; ?>">
                        <input type="hidden" name="fecha_entrega" value="<?= $fecha_entrega ?? ''; ?>">
                        <input type="hidden" name="metodo_pago" value="<?= $metodo_pago ?? ''; ?>">
                        <input type="hidden" name="fecha_pago" value="<?= $fecha_pago ?? ''; ?>">
                        <input type="hidden" name="codigo_referido" value="<?= $codigo_referido ?? ''; ?>">

                        <!-- Los datos del paso 1 se pasarán mediante JavaScript -->

                        <!-- Contenedor para campos dinámicos -->
<div id="camposDinamicos">
    <?php if (!empty($camposFormulario)): ?>
        <?php
        $grupos = [];
        $grupoActual = ['tipo' => 'campos', 'items' => []];

        foreach ($camposFormulario as $index => $campo) {
            $tipo = $campo['tipo'] ?? 'texto';
            if ($tipo === 'titulo' || $tipo === 'parrafo') {
                if (!empty($grupoActual['items'])) {
                    $grupos[] = $grupoActual;
                    $grupoActual = ['tipo' => 'campos', 'items' => []];
                }
                $grupos[] = ['tipo' => $tipo, 'items' => [$campo]];
            } else {
                $grupoActual['items'][] = $campo;
            }
        }
        if (!empty($grupoActual['items'])) {
            $grupos[] = $grupoActual;
        }
        ?>

        <?php foreach ($grupos as $grupo): ?>

            <?php if ($grupo['tipo'] === 'titulo'): ?>
                <?php $campo = $grupo['items'][0]; ?>
                <?php $nivel = htmlspecialchars($campo['nivel'] ?? 'h5'); ?>
                <div class="campo-formulario w-100 mb-2 mt-3">
                    <<?= $nivel ?> class="form-section-title border-bottom pb-1 mb-0">
                        <?= htmlspecialchars($campo['contenido'] ?? '') ?>
                    </<?= $nivel ?>>
                </div>

            <?php elseif ($grupo['tipo'] === 'parrafo'): ?>
                <?php $campo = $grupo['items'][0]; ?>
                <div class="campo-formulario w-100 mb-3">
                    <p class="text-muted mb-0">
                        <?= nl2br(htmlspecialchars($campo['contenido'] ?? '')) ?>
                    </p>
                </div>

            <?php else: ?>
                <?php
                // Contar solo campos que NO son archivo ni textarea para el grid
                $camposGrid = array_filter($grupo['items'], fn($c) => !in_array($c['tipo'] ?? 'texto', ['archivo', 'textarea']));
                $totalGrid  = count($camposGrid);
                if ($totalGrid === 1) {
                    $colBase = 'col-12';
                } elseif ($totalGrid === 2) {
                    $colBase = 'col-12 col-md-6';
                } else {
                    $colBase = 'col-12 col-md-6 col-lg-4';
                }
                ?>
                <div class="row">
                    <?php foreach ($grupo['items'] as $index => $campo): ?>
                        <?php
                        $campoId       = $campo['id']          ?? 'campo_' . $index;
                        $tipo          = $campo['tipo']         ?? 'texto';
                        $label         = htmlspecialchars($campo['label']       ?? '');
                        $name          = htmlspecialchars($campo['name']        ?? 'campo_' . $index);
                        $ayuda         = htmlspecialchars($campo['ayuda']       ?? '');
                        $placeholder   = htmlspecialchars($campo['placeholder'] ?? '');
                        $requerido     = $campo['requerido']   ?? false;
                        $requeridoAttr = $requerido ? 'required' : '';
                        // archivo y textarea siempre full width
                        $colClass = in_array($tipo, ['archivo', 'textarea']) ? 'col-12' : $colBase;
                        ?>

                        <div class="<?= $colClass ?> mb-4 campo-formulario" data-campo-id="<?= $campoId ?>">

                            <?php if ($tipo === 'texto'): ?>
                                <div class="form-group">
                                    <label for="<?= $name ?>" class="form-label">
                                        <?= $label ?>
                                        <?php if ($requerido): ?><span class="text-danger">*</span><?php endif; ?>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="<?= $name ?>" name="<?= $name ?>"
                                           placeholder="<?= $placeholder ?>"
                                           <?= $requeridoAttr ?> autocomplete="off">
                                    <?php if (!empty($ayuda)): ?>
                                        <div class="form-text"><?= $ayuda ?></div>
                                    <?php endif; ?>
                                </div>

                            <?php elseif ($tipo === 'numero'): ?>
                                <div class="form-group">
                                    <label for="<?= $name ?>" class="form-label">
                                        <?= $label ?>
                                        <?php if ($requerido): ?><span class="text-danger">*</span><?php endif; ?>
                                    </label>
                                    <input type="number" class="form-control"
                                           id="<?= $name ?>" name="<?= $name ?>"
                                           placeholder="<?= $placeholder ?>"
                                           <?= $requeridoAttr ?>
                                           <?= isset($campo['min'])  ? 'min="'  . $campo['min']  . '"' : '' ?>
                                           <?= isset($campo['max'])  ? 'max="'  . $campo['max']  . '"' : '' ?>
                                           <?= isset($campo['step']) ? 'step="' . $campo['step'] . '"' : '' ?>
                                           autocomplete="off">
                                    <?php if (!empty($ayuda)): ?>
                                        <div class="form-text"><?= $ayuda ?></div>
                                    <?php endif; ?>
                                </div>

                            <?php elseif ($tipo === 'textarea'): ?>
                                <div class="form-group">
                                    <label for="<?= $name ?>" class="form-label">
                                        <?= $label ?>
                                        <?php if ($requerido): ?><span class="text-danger">*</span><?php endif; ?>
                                    </label>
                                    <textarea class="form-control"
                                              id="<?= $name ?>" name="<?= $name ?>"
                                              placeholder="<?= $placeholder ?>"
                                              rows="<?= $campo['filas'] ?? 4 ?>"
                                              <?= $requeridoAttr ?>></textarea>
                                    <?php if (!empty($ayuda)): ?>
                                        <div class="form-text"><?= $ayuda ?></div>
                                    <?php endif; ?>
                                </div>

                            <?php elseif ($tipo === 'select'): ?>
                                <div class="form-group">
                                    <label for="<?= $name ?>" class="form-label">
                                        <?= $label ?>
                                        <?php if ($requerido): ?><span class="text-danger">*</span><?php endif; ?>
                                    </label>
                                    <select class="form-control" id="<?= $name ?>" name="<?= $name ?>" <?= $requeridoAttr ?>>
                                        <?php if (!empty($placeholder)): ?>
                                            <option value=""><?= $placeholder ?></option>
                                        <?php else: ?>
                                            <option value="">Seleccione una opción</option>
                                        <?php endif; ?>
                                        <?php foreach ($campo['opciones'] ?? [] as $opcion): ?>
                                            <option value="<?= htmlspecialchars($opcion) ?>">
                                                <?= htmlspecialchars($opcion) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (!empty($ayuda)): ?>
                                        <div class="form-text"><?= $ayuda ?></div>
                                    <?php endif; ?>
                                </div>

                            <?php elseif ($tipo === 'archivo'): ?>
                                <?php
                                $formatos      = $campo['formatos'] ?? 'pdf,jpg,jpeg,png';
                                $maxSize       = $campo['max_size'] ?? 5;
                                $formatosArray = explode(',', $formatos);
                                $acceptAttr    = '';
                                foreach ($formatosArray as $fmt) {
                                    $fmt = trim($fmt);
                                    if ($fmt === 'pdf') {
                                        $acceptAttr .= '.pdf,';
                                    } elseif (in_array($fmt, ['jpg','jpeg','png','gif'])) {
                                        $acceptAttr .= "image/$fmt,";
                                    } else {
                                        $acceptAttr .= ".$fmt,";
                                    }
                                }
                                $acceptAttr      = rtrim($acceptAttr, ',');
                                $formatosDisplay = array_map(fn($f) => strtoupper(trim($f)), $formatosArray);
                                ?>
                                <div class="form-group">
                                    <label for="<?= $name ?>" class="form-label">
                                        <i class="fa fa-upload me-1"></i>
                                        <?= $label ?>
                                        <?php if ($requerido): ?><span class="text-danger">*</span><?php endif; ?>
                                    </label>
                                    <input type="file" class="form-control"
                                           id="<?= $name ?>" name="<?= $name ?>"
                                           accept="<?= $acceptAttr ?>" <?= $requeridoAttr ?>>
                                    <div class="file-info mt-2">
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle me-1"></i>
                                            Formatos: <?= implode(', ', $formatosDisplay) ?>
                                            <?php if ($maxSize): ?> | Máx: <?= $maxSize ?> MB<?php endif; ?>
                                        </small>
                                    </div>
                                    <?php if (!empty($ayuda)): ?>
                                        <div class="form-text"><?= $ayuda ?></div>
                                    <?php endif; ?>
                                    <div class="preview-container mt-2" style="display:none;">
                                        <img id="preview_<?= $name ?>" src="" alt="Preview"
                                             class="img-thumbnail"
                                             style="max-width:200px; max-height:200px;">
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div><!-- /col -->
                    <?php endforeach; ?>
                </div><!-- /row -->

            <?php endif; ?>

        <?php endforeach; ?>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="fa fa-info-circle me-2"></i>
            No se han configurado campos adicionales para este formulario.
        </div>
    <?php endif; ?>
</div>

                        <!-- Términos y condiciones -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terminos" required>
                            <label class="form-check-label" for="terminos">
                                Acepto los <a href="../views/assets/files/terminos.pdf" target="_blank">términos y condiciones</a>
                                y la <a href="../views/assets/files/politicas-y-garantias-del-servicio.pdf" target="_blank">política de privacidad</a>
                                <span class="text-danger">*</span>
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="btnVolverPaso2">
                                <i class="fa fa-arrow-left me-2"></i>Anterior
                            </button>
                            <button type="submit" class="btn btn-primary px-4" name="btnRegistroCliente"
                                id="btnEnviarFormulario">
                                <i class="fa fa-paper-plane me-2"></i>Enviar Formulario
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        <i class="fa fa-shield-alt me-1"></i>
                        Sus datos están protegidos y serán usados únicamente para el proceso de trámite.
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal de información de cédula -->
<div class="modal fade" id="modalInfoCedula" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-info-circle me-2"></i>Información importante
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Para el número de cédula:</p>
                <ul>
                    <li>Ingrese solo números, sin puntos ni comas</li>
                    <li>Debe tener entre 6 y 12 dígitos</li>
                    <li>Verifique que la información sea correcta</li>
                    <li>Esta información es confidencial y segura</li>
                </ul>
                <div class="alert alert-warning mb-0">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    La información proporcionada será verificada para el proceso.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Loading -->
<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h5 class="text-white mt-3">Enviando formulario...</h5>
                <p class="text-light">Por favor espere un momento</p>
            </div>
        </div>
    </div>
</div>

<script src="<?= ASSETS_URL ?>/js/render-form.js"></script>