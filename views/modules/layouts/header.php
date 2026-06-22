<body>
    <section class="cabecera">
        <header>
            <div class="container d-flex align-items-center justify-content-between">
                <a href="index.php"> <img src="<?= ASSETS_URL; ?>/img/logo.png" alt="Logo Apostillas y Legalizaciones"
                        class="logo" width="220px" height="60px" /></a>

                <nav class="d-flex align-items-center menuweb">
                    <a href="index" class="link">Inicio</a>

                    <div class="dropdown-nav">
                        <button class="link dropdown-toggle" type="button">
                            Servicios
                        </button>
                        <ul class="dropdown-menu">
                            <li class="has-submenu">
                                <a href="#">Apostillas <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                <ul class="submenu">
                                    <li><a href="https://apostillas.co/" target="_blank">Apostilla en Colombia</a></li>
                                    <li><a href="https://usa.apostillas.co" target="_blank">Apostilla en Estados Unidos</a></li>
                                    <li><a href="apostilla-espana" >Apostilla en España</a></li>
                                    <li><a href="https://mexico.apostillas.co" target="_blank">Apostilla en México</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu">
                                <a href="#">Convalidaciones Académicas <i class="fa fa-chevron-right"
                                        aria-hidden="true"></i></a>
                                <ul class="submenu">
                                    <li><a href="https://convalidaciones.com/" target="_blank">Convalidaciones</a></li>
                                    <li><a href="https://api.whatsapp.com/send/?phone=573005023755&text=Necesito%20asesor%C3%ADa%20para%20convalidaci%C3%B3n%20acad%C3%A9mica&type=phone_number&app_absent=0"
                                            target="_blank">Asesórate en tu convalidación</a></li>
                                    <li><a href="radicacion-convalidacion">Radicación de convalidación</a></li>
                                    <li><a href="convalidar-titulo">¿Es posible convalidar tu título? </a></li>
                                    <li><a href="casos-exito">Casos de éxito</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="traducciones-oficiales">Traducciones Oficiales</a>
                            </li>
                            <li>
                                <a href="recoleccion-documentos"> Recolección de Documentos</a>
                            </li>
                            <li>
                                <a href="estudiar"> ¿Quieres Estudiar?</a>
                            </li>
                            <li class="has-submenu">
                                <a href="#"> Asesoría Legal Educativa <i class="fa fa-chevron-right"
                                        aria-hidden="true"></i></a>
                                <ul class="submenu">
                                    <li><a href="tutelas">Tutelas</a></li>
                                    <li><a href="derecho-peticion">Derecho de Petición</a></li>
                                    <li><a href="asesoria-legal-personalizada">Asesoría legal personalizada</a></li>
                                    <li><a href="respuesta-men">Respuesta a requerimientos del MEN</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="https://apostillasylegalizaciones.com/credito"> Financiar convalidación</a>
                            </li>
                            <li>
                                <a href="https://apostillasylegalizaciones.com/referidos"> Ganar comisiones </a>
                            </li>
                        </ul>
                    </div>

                    <a href="nosotros" class="link">Quiénes Somos</a>

                    <div class="dropdown-nav">
                        <button class="link dropdown-toggle" type="button">
                            Atención al cliente
                        </button>

                        <ul class="dropdown-menu">
                            <li> <a href="casos-exito">Historias de Éxito</a></li>
                            <li> <a href="views/assets/files/politicas-y-garantias-del-servicio.pdf" target="_blank">Garantías
                                    y Políticas</a></li>
                            <li> <a href="https://api.whatsapp.com/send/?phone=573005023755&text=Solicitar+cita+o+reportar+caso&type=phone_number&app_absent=0
                                " target="_blank"> Solicita una Cita o Reporta tu Caso</a></li>
                            <li> <a href="preguntas-frecuentes">Preguntas Frecuentes (FAQ)</a></li>
                            <li> <a href="#" data-bs-toggle="modal" data-bs-target="#metodopagos">Zona de Pagos
                                    Seguros</a></li>
                        </ul>
                    </div>

                    <a href="contacto" class="link">Contacto</a>
                </nav>

                <button type="button" class="btn_menu_mobile" id="btn_menu_mobile" onclick="swicheMenuMobile()">
                    <i class="fa fa-bars"></i> Menu
                </button>

                <div class="menu_mobile">
                    <button type="button" onclick="swicheMenuMobile()"><i class="fa fa-times"></i></button>

                    <a href="index" class="link">Inicio</a>

                    <p>Servicios</p>

                    <p id="apostillas">Apostillas <span class="arrow">▼</span></p>
                    <ul id="ul-apostillas">
                        <li><a href="apostilla-colombia">Apostilla en Colombia</a></li>
                        <li><a href="apostilla-usa">Apostilla en Estados Unidos</a></li>
                        <li><a href="apostilla-espana">Apostilla en España</a></li>
                    </ul>

                    <p id="convalidaciones">Convalidaciones Académicas <span class="arrow">▼</span></p>
                    <ul id="ul-convalidaciones">
                        <li><a href="https://api.whatsapp.com/send/?phone=573005023755&text=Necesito%20asesor%C3%ADa%20para%20convalidaci%C3%B3n%20acad%C3%A9mica&type=phone_number&app_absent=0"
                                target="_blank">Asesórate en tu convalidación</a></li>
                        <li><a href="radicacion-convalidacion">Radicación de convalidación</a></li>
                        <li><a href="convalidar-titulo">¿Es posible convalidar tu título?</a></li>
                        <li><a href="casos-exito">Casos de éxito</a></li>
                    </ul>

                    <a href="traducciones-oficiales">Traducciones Oficiales</a>
                    <a href="recoleccion-documentos">Recolección de Documentos</a>
                    <a href="estudiar">¿Quieres Estudiar?</a>

                    <p id="asesoria">Asesoría Legal Educativa <span class="arrow">▼</span></p>
                    <ul id="ul-asesoria">
                        <li><a href="tutelas">Tutelas</a></li>
                        <li><a href="derecho-peticion">Derecho de Petición</a></li>
                        <li><a href="asesoria-legal-personalizada">Asesoría legal personalizada</a></li>
                        <li><a href="respuesta-men">Respuesta a requerimientos del MEN</a></li>
                    </ul>

                    <a href="nosotros" class="link">Quiénes Somos</a>

                    <p id="atencioncliente">Atención al clientep<span class="arrow">▼</span></p>
                    <ul id="ul-atencioncliente">
                        <li><a href="casos-exito">Historias de Éxito</a></li>
                        <li><a href="views/assets/files/politicas-y-garantias-del-servicio.pdf" target="_blank">Garantías y
                                Políticas</a></li>
                        <li><a href="https://api.whatsapp.com/send/?phone=573005023755&text=Solicitar+cita+o+reportar+caso&type=phone_number&app_absent=0"
                                target="_blank">Solicita una Cita o Reporta tu Caso</a></li>
                        <li><a href="preguntas-frecuentes">Preguntas Frecuentes (FAQ)</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#metodopagos">Zona de Pagos Seguros</a>
                        </li>
                    </ul>

                    <a href="contacto" class="link">Contacto</a>
                </div>


            </div>
        </header>