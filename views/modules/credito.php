<?php
if (isset($_GET["param1"]) && $_GET["param1"] === "success") {
    ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- Header -->
                    <div class="bg-primary text-white text-center py-4">
                        <i class="fa fa-check-circle fa-4x mb-3"></i>
                        <h3 class="fw-bold mb-0">
                            ¡Solicitud recibida!
                        </h3>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-5 text-center">

                        <h5 class="fw-bold mb-3">
                            Hemos recibido tu solicitud de crédito
                        </h5>


                        <div class="alert alert-warning d-flex align-items-center justify-content-center rounded-3">
                            <i class="fa fa-hourglass-half me-2"></i>
                            <strong>Estado actual: EN PROCESO</strong>
                        </div>

                        <p class="mt-4">
                            Nuestro equipo está evaluando tu solicitud y se comunicará contigo
                            en el menor tiempo posible.
                        </p>

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

    <?php
} else {
    ?>
    <section class="convalidacion py-5">
        <div class="container">
            <!-- HEADER -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">
                    Personaliza y Financia
                    <span class="text-primary">TU PROCESO DE CONVALIDACIÓN </span>
                </h2>
                <p class="text-muted">
                    Escoge las opciones para tu convalidación y ve el costo total a financiar.
                </p>
            </div>

            <!-- PASO 1 -->
            <div class="step-box">
                <h5 class="step-title"><span>1</span> Elige la Velocidad de Apostilla:</h5>
                <hr />
                <h6>¿Qué tipo de servicio de apostilla prefieres?</h6>

                <div class="row g-3 mt-2">
                    <!-- FLASH -->
                    <div class="col-md-4">
                        <label class="option-card option-flash">
                            <input type="radio" name="velocidad" value="650000" class="costo" />
                            <p class="etiqueta_card">Prioridad máxima</p>
                            <div class="icon">
                                <i class="fa fa-bolt"></i>
                            </div>

                            <div class="content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">FLASH</h6>
                                    <i class="fa fa-check-circle check"></i>
                                </div>
                                <p class="text-info-card">2–4 días hábiles</p>
                                <span class="price">$650.000</span>
                                <p class="small text-muted mb-0 my-1">
                                    Convalida en el menor tiempo posible.
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- EXPRESS -->
                    <div class="col-md-4">
                        <label class="option-card option-express">
                            <input type="radio" name="velocidad" value="580000" class="costo" />
                            <p class="etiqueta_card etiqueta-elegida">La más elegida</p>

                            <div class="icon">
                                <i class="fa fa-rocket"></i>
                            </div>

                            <div class="content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">EXPRESS</h6>
                                    <i class="fa fa-check-circle check"></i>
                                </div>
                                <p class="text-info-card">6–9 días hábiles</p>
                                <span class="price">$580.000</span>
                                <p class="small text-muted mb-0 my-1">
                                    Equilibrio ideal para avanzar más rápido hacia tu convalidación.
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- ESTÁNDAR -->
                    <div class="col-md-4">
                        <label class="option-card option-standard">
                            <input type="radio" name="velocidad" value="520000" class="costo" />

                            <div class="icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>

                            <div class="content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">ESTÁNDAR</h6>
                                    <i class="fa fa-check-circle check"></i>
                                </div>
                                <p class="text-info-card">12–18 días hábiles</p>
                                <span class="price">$520.000</span>
                                <p class="small text-muted mb-0 my-1">
                                    Para quienes pueden avanzar sin urgencia.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- PASO 2 -->
            <div class="step-box">
                <h5 class="step-title"><span>2</span> Radicación ante el MEN:</h5>
                <hr />

                <h6>
                    Evita errores desde el inicio y avanza con acompañamiento profesional.
                </h6>

                <div class="row my-4">
                    <!-- CON RADICACIÓN -->
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <div class="radicacion-check">
                            <input class="form-check-input costo" type="radio" name="radicacion" value="60000"
                                id="radicacion_si" />

                            <label class="form-check-label d-flex align-items-start gap-2" for="radicacion_si">
                                <span>
                                    <strong>Sí, incluir radicación profesional $60.000</strong>
                                    <span class="text-primary"><strong>(tarifa especial)</strong></span>
                                    <br />
                                    <span class="small-info">
                                        <i class="fa fa-info-circle"></i>
                                        Acompañamiento completo para una inscripción correcta y sin
                                        contratiempos.
                                    </span>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- SIN RADICACIÓN -->
                    <div class="col-12 col-md-6">
                        <div class="radicacion-check">
                            <input class="form-check-input" type="radio" name="radicacion" value="0" id="radicacion_no" />

                            <label class="form-check-label d-flex align-items-start gap-2" for="radicacion_no">
                                <span>
                                    <strong>Prefiero hacerlo por mi cuenta</strong><br />
                                    <span class="small-info">
                                        <i class="fa fa-info-circle"></i>
                                        Puedes radicar directamente. Apostillas & Legalizaciones no se
                                        hace responsable por errores, omisiones o demoras generadas
                                        durante el proceso.
                                    </span>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 3 -->
            <div class="step-box">
                <h5 class="step-title"><span>3</span> Impulso Legal (opcional):</h5>
                <hr />
                <h6>Acelera tu convalidación y reduce tiempos de espera.</h6>

                <div class="row my-4">
                    <!-- ACELERAR -->
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <div class="impulso-check">
                            <input class="form-check-input costo" type="radio" name="impulso" value="120000"
                                id="impulso_si" />

                            <label class="form-check-label d-flex align-items-center gap-3" for="impulso_si">
                                <span class="icon-legal">
                                    <i class="fa fa-balance-scale"></i>
                                </span>

                                <span>
                                    <strong>Acelerar proceso</strong> - Impulso jurídico estratégico
                                    <br />
                                    <span class="text-sm">
                                        <del class="text-muted">$250.000</del> $120.000
                                        <strong class="text-primary">
                                            (Beneficio exclusivo por financiamiento)</strong>
                                    </span>
                                    <br />
                                    <small class="text-muted"></small>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- CONTINUAR NORMAL -->
                    <div class="col-md-6 col-12">
                        <div class="impulso-check">
                            <input class="form-check-input" type="radio" name="impulso" value="0" id="impulso_no" />

                            <label class="form-check-label d-flex align-items-center gap-3" for="impulso_no">
                                <span class="icon-legal text-secondary">
                                    <i class="fa fa-hourglass-half"></i>
                                </span>

                                <span>
                                    <strong>Continuar en tiempos regulares</strong><br />
                                    <small class="text-muted">El proceso seguirá su curso normal</small>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 4 -->
            <div class="step-box">
                <h5 class="step-title"><span>4</span> Pago Derechos MEN:</h5>
                <hr />
                <h6>Pago obligatorio exigido por el Ministerio para estudiar tu título.</h6>

                <div class="row my-4">
                    <!-- INCLUIR PAGO -->
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <div class="pago-check">
                            <input class="form-check-input costo" type="radio" name="pago_men" value="1037811"
                                id="pago_men_si" />

                            <label class="form-check-label d-flex align-items-start gap-2" for="pago_men_si">
                                <span>
                                    <strong>Incluir pago al MEN $1.037.811</strong><br />
                                    <span class="small-info">Valor oficial que se paga directamente al MEN</span><br />
                                    <small class="text-primary">Tasa oficial del Ministerio de Educación</small>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- PAGAR DIRECTO -->
                    <div class="col-md-6 col-12">
                        <div class="pago-check">
                            <input class="form-check-input" type="radio" name="pago_men" value="0" id="pago_men_no" />

                            <label class="form-check-label d-flex align-items-start gap-2" for="pago_men_no">
                                <span>
                                    <strong>Lo pagaré directamente al MEN</strong><br />
                                    <span class="small-info">
                                        Te enviaremos un instructivo paso a paso para realizar el pago
                                        correctamente.
                                    </span>
                                </span>

                                <span class="ms-auto check-icon">
                                    <i class="fa fa-check-circle"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>

    <!-- RESUMEN -->
    <div class="card shadow-sm border-0 summary-card">
        <!-- BARRA PROGRESO -->
        <div class="progress-top">
            <div class="progress-bar-top" id="progressBar"></div>
        </div>
        <div class="card-body p-4">
            <!-- Título -->
            <div class="container">
                <h5 class=" mb-2 text-light">Resumen de tu proceso</h5>

                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Tiempo -->
                    <div class="d-flex align-items-center">
                        <h5 class="text-light small me-1">Tiempo estimado </h5>
                        <h4 class="fw-bold  text-primary" id="tiempo">0 días</h4>
                    </div>

                    <!-- Total -->
                    <div class="d-flex align-items-center">
                        <h5 class="text-light small me-1">Total a financiar</h5>
                        <h4 class="fw-bold text-primary" id="total">$0</h4>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button id="btnFinanciar"
                            class="btn btn-light d-flex align-items-center justify-content-center gap-2" disabled>

                            Financiar ahora
                            <i class="fa fa-check"></i>
                        </button>

                    </div>
                </div>
            </div>


        </div>
    </div>


    <!-- MODAL FINAL -->
    <div class="modal fade" id="modalSolicitud" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-semibold">Último paso para enviar tu solicitud</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="formSolicitud" method="post">
                    <div class="modal-body p-4">

                        <p class="text-muted small mb-4">
                            Para finalizar tu proceso, ingresa tus datos y enviaremos la solicitud a nuestro equipo.
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Nombre y apellido</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de documento</label>
                            <input type="text" class="form-control" name="documento" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Celular</label>
                            <input type="tel" class="form-control" name="celular" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" name="enviarSolicitud" class="btn btn-primary px-4">
                            Enviar solicitud
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <style>
        @media (max-width: 991px) {
            .sticky-summary {
                position: relative;
                top: 0;
                margin-top: 2rem;
            }
        }

        .impulso-check .form-check-input {
            display: none;
        }

        .impulso-check label {
            cursor: pointer !important;
        }

        .small-info {
            font-size: 13px;
            margin-top: 5px;
        }

        .convalidacion {
            background: #f8f9fb;
        }

        .step-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .step-title {
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .step-title span {
            background-color: #090830;
            color: #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 5px;
        }

        .etiqueta_card {
            position: absolute;
            margin: 0;
            right: 1rem;
            top: .5rem;
            font-size: 13px;
            color: #fff;
            background-color: #000;
            box-sizing: border-box;
            padding: 3px 10px;
            border-radius: 15px;
        }

        .etiqueta-elegida {
            background-color: #BF3317;
        }

        /* TARJETA */
        .option-card {
            display: flex;
            gap: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            cursor: pointer;
            transition: all .2s ease;
            height: 100%;
            align-items: start;
            position: relative;
        }

        /* ocultar radio */
        .option-card input {
            display: none;
        }

        /* HOVER */
        .option-card:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
        }

        /* ICONO GRANDE */
        .option-card .icon {
            font-size: 60px;
            width: 60px;
            text-align: center;
        }

        /* COLORES POR TIPO */
        .option-flash .icon {
            color: #ffc107;
        }

        /* amarillo rayo */
        .option-express .icon {
            color: #0d6efd;
        }

        /* azul cohete */
        .option-standard .icon {
            color: #666;
        }

        /* verde check */

        /* CHECK DERECHO */
        .option-card .check {
            font-size: 20px;
            color: #dee2e6;
            transition: .2s;
            margin-left: 15px;
            position: relative;
            top: 2rem;
        }

        /* SELECCIONADO */
        .option-card input:checked+.icon+.content .check {
            color: #0d6efd;
        }

        /* BORDE ACTIVO */
        .option-card input:checked+.icon+.content {
            color: #0d6efd;
        }

        .option-card input:checked~* {
            filter: none;
        }

        .option-card input:checked {
            outline: none;
        }

        .option-card input:checked+.icon,
        .option-card input:checked+.icon+.content {
            font-weight: 600;
        }

        /* borde cuando está seleccionado */
        .option-card input:checked~.content,
        .option-card input:checked+.icon {}

        .option-card input:checked~* {}

        .option-card input:checked {}

        .option-card input:checked~.icon,
        .option-card input:checked~.content {}

        .option-card input:checked+.icon,
        .option-card input:checked+.icon+.content {}

        .option-card input:checked+.icon,
        .option-card input:checked+.icon+.content {}

        .option-card input:checked {}

        .option-card input:checked~* {}

        /* forma correcta de activar borde */
        .option-card:has(input:checked) {
            border-color: #0d6efd;
            background: #F0FDFF;
        }

        .content h6 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .price {
            font-weight: bold;
            color: #fff;
            background-color: #0d6efd;
            padding: .3rem 1rem;
            border-radius: 15px;
            margin: 5px 0;
            display: block;
            width: max-content;
        }

        .text-info-card {
            font-size: 14px;
            color: #000;
            margin: 4px 0;
        }

        .option-card.active {
            border-color: #198754;
            background: #f0fff4;
        }

        .option-card.active .check {
            color: #0d6efd;
        }

        /* CONTENEDOR TIPO TARJETA */
        .impulso-check {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            transition: all .2s ease;
            cursor: pointer;
        }

        /* ocultar checkbox real */
        .impulso-check .form-check-input {
            display: none;
        }

        /* ICONO BALANZA */
        .icon-legal {
            font-size: 26px;
            color: #c9a227;
            /* dorado elegante */
            width: 40px;
            text-align: center;
        }

        /* CHECK DERECHO */
        .check-icon {
            font-size: 20px;
            color: #dee2e6;
            transition: .2s;
        }

        /* HOVER */
        .impulso-check:hover {
            border-color: #0d6efd;
        }

        /* ESTADO ACTIVO */
        .impulso-check:has(input:checked) {
            border-color: #0d6efd;
            background: #F0FDFF;
        }

        /* CHECK VERDE CUANDO ESTÁ ACTIVO */
        .impulso-check:has(input:checked) .check-icon {
            color: #0d6efd;
        }



        .summary-box {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }


        .impulso-check.active {
            border-color: #c9a227;
            background: #fff8dc;
        }

        .impulso-check.active .check-icon {
            color: #198754;
        }

        .form-check {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            width: 100%;
            height: 100%;
        }

        /* ===============================
       TARJETA RADICACIÓN
    ================================ */
        .radicacion-check {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px 18px;
            transition: all .2s ease;
            cursor: pointer;
            height: 100%;
        }

        .radicacion-check label {
            cursor: pointer !important;
        }

        /* ocultar radio real */
        .radicacion-check .form-check-input {
            display: none;
        }

        /* hover */
        .radicacion-check:hover {
            border-color: #0d6efd;
            background: #f8fbff;
        }

        /* estado activo */
        .radicacion-check.active {
            border-color: #0d6efd;
            background: #F0FDFF;
        }

        /* check derecho */
        .radicacion-check .check-icon {
            font-size: 20px;
            color: #dee2e6;
            transition: .2s;
        }

        /* check azul cuando está seleccionado */
        .radicacion-check.active .check-icon {
            color: #0d6efd;
        }

        /* ===============================
       TARJETA PAGO MEN
    ================================ */
        .pago-check {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px 18px;
            transition: all .2s ease;
            cursor: pointer;
            height: 100%;
        }

        .pago-check label {
            cursor: pointer !important;
        }

        /* ocultar radio real */
        .pago-check .form-check-input {
            display: none;
        }

        /* hover */
        .pago-check:hover {
            border-color: #0d6efd;
            background: #f8fbff;
        }

        /* estado activo */
        .pago-check.active {
            border-color: #0d6efd;
            background: #F0FDFF;
        }

        /* check derecho */
        .pago-check .check-icon {
            font-size: 20px;
            color: #dee2e6;
            transition: .2s;
        }

        /* check azul cuando está seleccionado */
        .pago-check.active .check-icon {
            color: #0d6efd;
        }

        .summary-card {
            background: linear-gradient(135deg, #090830 0%, #2a2779 100%) !important;
            color: #fff !important;
            position: fixed;
            border-radius: 0 !important;
            width: 100%;
            bottom: 0;
            z-index: 3;
            overflow: hidden;
        }

        /* contenedor de progreso */
        .progress-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.08);
        }

        /* barra que avanza */
        .progress-bar-top {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #00d4ff, #7c4dff);
            transition: width 0.35s ease;
        }
    </style>

    <script>
        document.querySelectorAll('.option-card input').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.option-card').forEach(card => {
                    card.classList.remove('active');
                });

                radio.closest('.option-card').classList.add('active');
            });
        });

        document.querySelectorAll('.impulso-check input').forEach(input => {

            input.addEventListener('change', () => {

                // quitar activo a todos los del mismo grupo
                document.querySelectorAll(`.impulso-check input[name="${input.name}"]`)
                    .forEach(i => i.closest('.impulso-check').classList.remove('active'));

                // activar el seleccionado
                input.closest('.impulso-check').classList.add('active');
            });

        });

        document.querySelectorAll('.radicacion-check input').forEach(input => {

            input.addEventListener('change', () => {

                // quitar activo a todos del mismo grupo
                document.querySelectorAll(`.radicacion-check input[name="${input.name}"]`)
                    .forEach(i => i.closest('.radicacion-check').classList.remove('active'));

                // activar el seleccionado
                input.closest('.radicacion-check').classList.add('active');
            });

        });

        document.querySelectorAll('.pago-check input').forEach(input => {

            input.addEventListener('change', () => {

                // quitar activo a todos del mismo grupo
                document.querySelectorAll(`.pago-check input[name="${input.name}"]`)
                    .forEach(i => i.closest('.pago-check').classList.remove('active'));

                // activar el seleccionado
                input.closest('.pago-check').classList.add('active');
            });

        });


    </script>

    <script>
        const TIEMPOS = {
            velocidad: {
                650000: 4,
                580000: 11,
                520000: 20,
            },
            radicacion: {
                60000: 0,
                0: 6,
            },
            impulso: {
                120000: 15,
                0: 75,
            },
            pago_men: {
                1037811: 0,
                0: 5,
            },
        };

        const PLAZO_MEN = 60;

        const totalEl = document.getElementById("total");
        const tiempoEl = document.getElementById("tiempo");
        const btn = document.getElementById("btnFinanciar");

        const GRUPOS = ["velocidad", "radicacion", "impulso", "pago_men"];


        /* =========================
           ACTIVAR TARJETAS
        ========================= */
        function activarGrupo(selector, clase) {
            document.querySelectorAll(selector).forEach((input) => {
                input.addEventListener("change", () => {
                    document
                        .querySelectorAll(`${selector}[name="${input.name}"]`)
                        .forEach((i) => i.closest(clase).classList.remove("active"));

                    input.closest(clase).classList.add("active");

                    calcularResumen();
                });
            });
        }

        activarGrupo(".option-card input", ".option-card");
        activarGrupo(".radicacion-check input", ".radicacion-check");
        activarGrupo(".impulso-check input", ".impulso-check");
        activarGrupo(".pago-check input", ".pago-check");

        /* =========================
           OBTENER VALOR SELECCIONADO
        ========================= */
        function getValor(name) {
            const checked = document.querySelector(`input[name="${name}"]:checked`);
            return checked ? Number(checked.value) : null;
        }

        const progressBar = document.getElementById("progressBar");

        function actualizarProgreso() {
            let completados = 0;

            GRUPOS.forEach((grupo) => {
                if (getValor(grupo) !== null) completados++;
            });

            const porcentaje = (completados / GRUPOS.length) * 100;

            progressBar.style.width = porcentaje + "%";
        }


        /* =========================
           CALCULAR RESUMEN
        ========================= */
        function calcularResumen() {
            let total = 0;
            let seleccionCompleta = true;

            GRUPOS.forEach((grupo) => {
                const val = getValor(grupo);

                if (val === null) {
                    seleccionCompleta = false;
                } else {
                    total += val;
                }
            });

            /* -------- TOTAL DINERO -------- */
            totalEl.textContent = total.toLocaleString("es-CO", {
                style: "currency",
                currency: "COP",
                minimumFractionDigits: 0,
            });

            /* -------- TIEMPO EN TIEMPO REAL -------- */

            const A = TIEMPOS.velocidad[getValor("velocidad")] ?? 0;
            const R = TIEMPOS.radicacion[getValor("radicacion")] ?? 0;
            const M = TIEMPOS.pago_men[getValor("pago_men")] ?? 0;
            const I = TIEMPOS.impulso[getValor("impulso")] ?? 0;

            const diasTotales = A + R + M + PLAZO_MEN + I;

            const meses = Math.floor(diasTotales / 30);
            const dias = diasTotales % 30;

            tiempoEl.textContent =
                meses > 0
                    ? `${meses} mes${meses > 1 ? "es" : ""} ${dias} días`
                    : `${diasTotales} días`;

            /* -------- BOTÓN -------- */
            btn.disabled = !seleccionCompleta;

            actualizarProgreso();
        }


        btn.addEventListener("click", () => {
            // Obtener valores seleccionados
            const velocidadVal = getValor("velocidad");
            const radicacionVal = getValor("radicacion");
            const impulsoVal = getValor("impulso");
            const pagoMenVal = getValor("pago_men");

            // Textos legibles
            const textos = {
                velocidad: {
                    650000: "FLASH (Prioridad máxima)",
                    580000: "EXPRESS (La más elegida)",
                    520000: "ESTÁNDAR",
                },
                radicacion: {
                    60000: "Radicación profesional incluida",
                    0: "Radicación por cuenta propia",
                },
                impulso: {
                    120000: "Impulso legal estratégico",
                    0: "Proceso en tiempos regulares",
                },
                pago_men: {
                    1037811: "Pago MEN incluido",
                    0: "Pago MEN directo por el cliente",
                },
            };

            // Tiempo ya calculado en pantalla
            const tiempoTexto = tiempoEl.textContent;
            const totalTexto = totalEl.textContent;

            Swal.fire({
                title: "Resumen de tu solicitud",
                html: `
            <div style="text-align:left; font-size:14px">
                <p><strong>Velocidad de apostilla:</strong><br>${textos.velocidad[velocidadVal]}</p>
                <p><strong>Radicación MEN:</strong><br>${textos.radicacion[radicacionVal]}</p>
                <p><strong>Impulso legal:</strong><br>${textos.impulso[impulsoVal]}</p>
                <p><strong>Pago derechos MEN:</strong><br>${textos.pago_men[pagoMenVal]}</p>

                <hr>

                <p><strong>Tiempo estimado:</strong> ${tiempoTexto}</p>
                <p style="font-size:18px"><strong>Total a financiar:</strong> ${totalTexto}</p>
            </div>
        `,
                icon: "info",
                confirmButtonText: "Continuar",
                confirmButtonColor: "#2a2779",
                showCancelButton: true,
                cancelButtonText: "Editar",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    abrirModalVacio();
                }
            });
        });

        function abrirModalVacio() {
            const modal = new bootstrap.Modal(document.getElementById("modalSolicitud"));
            modal.show();
        }

        document.getElementById("formSolicitud").addEventListener("submit", function () {

            const velocidadVal = getValor("velocidad");
            const radicacionVal = getValor("radicacion");
            const impulsoVal = getValor("impulso");
            const pagoMenVal = getValor("pago_men");

            /* =========================
               CONVERTIR A TEXTO LEGIBLE
            ========================= */

            const velocidadTexto = {
                650000: "FLASH",
                580000: "EXPRESS",
                520000: "ESTANDAR"
            }[velocidadVal];

            const radicacionTexto = radicacionVal == 60000 ? "SI" : "NO";
            const impulsoTexto = impulsoVal == 120000 ? "SI" : "NO";
            const pagoMenTexto = pagoMenVal == 1037811 ? "SI" : "NO";

            const datos = {
                velocidad: velocidadTexto,
                radicacion: radicacionTexto,
                impulso: impulsoTexto,
                pago_men: pagoMenTexto,
                tiempo: tiempoEl.textContent,
                total: totalEl.textContent,
            };


            Object.entries(datos).forEach(([key, value]) => {
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = key;
                input.value = value;
                this.appendChild(input);
            });

        });



    </script>

    <?php
    $post = new creditoController();
    $post->crearSolicitud();
    ?>

    <style>
        @media (max-width: 600px) {
            .no-wpp-mobile {
                display: none;
            }
        }
    </style>

    <?php
}
?>