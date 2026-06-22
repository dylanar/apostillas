document.addEventListener("DOMContentLoaded", function () {
  // Variables para manejo de pasos
  const paso1 = document.querySelector(".paso-1");
  const paso2 = document.querySelector(".paso-2");
  const steps = document.querySelectorAll(".step");
  const stepLine = document.querySelector(".step-line");

  // Botones de navegación
  const btnSiguientePaso1 = document.getElementById("btnSiguientePaso1");
  const btnVolverPaso2 = document.getElementById("btnVolverPaso2");
  const btnEnviarFormulario = document.getElementById("btnEnviarFormulario");
  const btnInfoCedula = document.getElementById("btnInfoCedula");

  // Campos del formulario
  const formPaso1 = document.getElementById("formPaso1");
  const formPaso2 = document.getElementById("formPaso2");
  const celular = document.getElementById("celular");
  const whatsapp = document.getElementById("whatsapp");
  const cedula = document.getElementById("cedula");

  // ============================================
  // INTL TEL INPUT - INICIALIZACIÓN
  // ============================================
  
  let itiCelular = null;
  let itiWhatsapp = null;

  // Función para inicializar los teléfonos
  function inicializarTelefonos() {
    // Verificar que existan los elementos
    if (celular && typeof window.intlTelInput !== 'undefined') {
      // Destruir instancia anterior si existe
      if (itiCelular) {
        itiCelular.destroy();
      }
      
      itiCelular = window.intlTelInput(celular, {
        initialCountry: "co",
        preferredCountries: ["co", "us", "mx", "es", "ar", "cl", "pe"],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.5.0/js/utils.js",
        autoPlaceholder: "polite",
        formatOnDisplay: true,
        hiddenInput: "full_phone"
      });
    }

    if (whatsapp && typeof window.intlTelInput !== 'undefined') {
      // Destruir instancia anterior si existe
      if (itiWhatsapp) {
        itiWhatsapp.destroy();
      }
      
      itiWhatsapp = window.intlTelInput(whatsapp, {
        initialCountry: "co",
        preferredCountries: ["co", "us", "mx", "es", "ar", "cl", "pe"],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.5.0/js/utils.js",
        autoPlaceholder: "polite",
        formatOnDisplay: true
      });
    }
  }

  // Inicializar teléfonos
  setTimeout(() => {
      inicializarTelefonos();
      
      // Forzar que los valores precargados se procesen correctamente
      if (celular && celular.value && itiCelular) {
        itiCelular.setNumber(celular.value);
      }
      if (whatsapp && whatsapp.value && itiWhatsapp) {
        itiWhatsapp.setNumber(whatsapp.value);
      }
    }, 200);

  // Auto-copiar celular a WhatsApp si está vacío
  if (celular && whatsapp) {
    celular.addEventListener("blur", function () {
      if (whatsapp.value === "" && this.value.trim() !== "") {
        whatsapp.value = this.value;
        // También actualizar el número completo en WhatsApp si existe
        if (itiWhatsapp && itiCelular) {
          const celularNumber = itiCelular.getNumber();
          if (celularNumber) {
            itiWhatsapp.setNumber(celularNumber);
          }
        }
      }
    });
  }

  // ============================================
  // FUNCIONES PRINCIPALES
  // ============================================

  // Actualizar indicador de pasos
  function actualizarPasos(pasoActual) {
    steps.forEach((step) => {
      step.classList.remove("active");
      if (parseInt(step.dataset.step) <= pasoActual) {
        step.classList.add("active");
      }
    });

    // Actualizar línea de progreso
    stepLine.style.width = pasoActual === 1 ? "0%" : "100%";
  }

  // Cambiar entre pasos
  function cambiarPaso(pasoDestino) {
    if (pasoDestino === 1) {
      paso1.style.display = "block";
      paso2.style.display = "none";
      actualizarPasos(1);
    } else if (pasoDestino === 2) {
      paso1.style.display = "none";
      paso2.style.display = "block";
      actualizarPasos(2);

      // Configurar previews de archivos cuando se muestre el paso 2
      setTimeout(() => {
        setupFilePreviews();
      }, 100);
    }
  }

  // ============================================
  // FUNCIONES PARA MANEJO DE ARCHIVOS
  // ============================================

  // Función para mostrar preview de imágenes
  function setupFilePreviews() {
    document.querySelectorAll('input[type="file"]').forEach((input) => {
      // Limpiar evento anterior para evitar duplicados
      input.removeEventListener("change", handleFilePreview);
      input.addEventListener("change", handleFilePreview);
    });
  }

  function handleFilePreview(e) {
    const file = e.target.files[0];
    const input = e.target;
    const previewId = "preview_" + input.name;
    const formGroup = input.closest(".form-group");
    const previewContainer = formGroup
      ? formGroup.querySelector(".preview-container")
      : null;
    const previewImg = document.getElementById(previewId);

    if (previewImg && file && previewContainer) {
      const reader = new FileReader();

      reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewContainer.style.display = "block";
      };

      // Solo mostrar preview si es imagen
      if (file.type.startsWith("image/")) {
        reader.readAsDataURL(file);
      } else {
        previewContainer.style.display = "none";
      }
    }
  }

  // Función para validar tamaño de archivos
  function validarArchivo(input) {
    const formGroup = input.closest(".form-group");
    const fileInfo = formGroup ? formGroup.querySelector(".file-info") : null;
    let maxSizeMB = 5;

    if (fileInfo) {
      const text = fileInfo.textContent;
      const match = text.match(/Máx: (\d+)/);
      if (match) {
        maxSizeMB = parseInt(match[1]);
      }
    }

    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    if (input.files && input.files[0]) {
      const file = input.files[0];

      if (file.size > maxSizeBytes) {
        Swal.fire({
          icon: "error",
          title: "Archivo demasiado grande",
          text: `El archivo excede el tamaño máximo de ${maxSizeMB} MB`,
          confirmButtonColor: "#090830",
        });
        input.value = "";
        return false;
      }

      // Validar extensión si hay atributo accept
      if (input.accept) {
        const allowedExtensions = input.accept
          .split(",")
          .map((ext) => {
            ext = ext.trim();
            if (ext.startsWith(".")) {
              return ext.replace(".", "");
            } else if (ext.startsWith("image/")) {
              return ext.replace("image/", "");
            }
            return ext;
          })
          .filter((ext) => ext !== "*");

        if (allowedExtensions.length > 0) {
          const fileExtension = file.name.split(".").pop().toLowerCase();
          const fileType = file.type;

          const isValid = allowedExtensions.some((ext) => {
            if (ext === fileExtension) return true;
            if (ext === fileType) return true;
            if (ext === "jpg" && fileExtension === "jpeg") return true;
            if (ext === "jpeg" && fileExtension === "jpg") return true;
            return false;
          });

          if (!isValid) {
            Swal.fire({
              icon: "error",
              title: "Formato no válido",
              text: `El formato del archivo no está permitido. Formatos aceptados: ${input.accept}`,
              confirmButtonColor: "#090830",
            });
            input.value = "";
            return false;
          }
        }
      }
    }
    return true;
  }

  // ============================================
  // FUNCIONES DE VALIDACIÓN
  // ============================================

  // Validación de cédula (solo números)
  if (cedula) {
    cedula.addEventListener("input", function () {
      this.value = this.value.replace(/\D/g, "");
    });
  }

  // ============================================
  // VALIDACIÓN DEL PASO 1
  // ============================================

  if (btnSiguientePaso1) {
    btnSiguientePaso1.addEventListener("click", function () {
      // Validar campos requeridos del paso 1
      const nombres = document.getElementById("nombres").value.trim();
      const apellidos = document.getElementById("apellidos").value.trim();
      const correo = document.getElementById("correo").value.trim();
      const cedulaVal = cedula ? cedula.value.trim() : "";

      if (!nombres || !apellidos || !correo || !cedulaVal) {
        Swal.fire({
          icon: "error",
          title: "Campos incompletos",
          text: "Por favor complete todos los campos obligatorios",
          confirmButtonColor: "#090830",
        });
        return;
      }
    const celularNumeros = celular ? celular.value.replace(/\D/g, "") : "";
    if (celularNumeros.length < 7) {
      Swal.fire({
        icon: "error",
        title: "Celular inválido",
        text: "Por favor ingrese un número de contacto válido",
        confirmButtonColor: "#090830",
      });
      celular.focus();
      return;
    }
      // Validar formato de email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(correo)) {
        Swal.fire({
          icon: "error",
          title: "Correo inválido",
          text: "Por favor ingrese un correo electrónico válido",
          confirmButtonColor: "#090830",
        });
        document.getElementById("correo").focus();
        return;
      }

      // Validar cédula
      if (cedulaVal.length < 6 || cedulaVal.length > 12) {
        Swal.fire({
          icon: "error",
          title: "Cédula inválida",
          text: "La cédula debe tener entre 6 y 12 dígitos",
          confirmButtonColor: "#090830",
        });
        cedula.focus();
        return;
      }

      // Obtener números completos para mostrar en el resumen
      const celularCompleto = itiCelular ? itiCelular.getNumber() : celular.value;
      const whatsappCompleto = (whatsapp && whatsapp.value.trim() !== "" && itiWhatsapp) ? itiWhatsapp.getNumber() : null;

      // Mostrar resumen antes de continuar
      Swal.fire({
        title: "¿Desea continuar al siguiente paso?",
        html: `
          <div class="text-start">
            <p>Verifique sus datos personales:</p>
            <div class="table-responsive">
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <td><strong>Nombre completo:</strong></td>
                    <td>${nombres} ${apellidos}</td>
                  </tr>
                  <tr>
                    <td><strong>Cédula:</strong></td>
                    <td>${cedulaVal}</td>
                  </tr>
                  <tr>
                    <td><strong>Correo:</strong></td>
                    <td>${correo}</td>
                  </tr>
                  <tr>
                    <td><strong>Celular:</strong></td>
                    <td>${celularCompleto}</td>
                  </tr>
                  ${whatsappCompleto ? `<tr><td><strong>WhatsApp:</strong></td><td>${whatsappCompleto}</td></tr>` : ''}
                </tbody>
              </table>
            </div>
            <div class="alert alert-warning mt-3 mb-0">
              <i class="fa fa-exclamation-triangle me-2"></i>
              En el siguiente paso deberá completar la documentación requerida.
            </div>
          </div>
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Editar",
        confirmButtonColor: "#090830",
        cancelButtonColor: "#6c757d",
        width: "600px",
      }).then((result) => {
        if (result.isConfirmed) {
          // Agregar campos ocultos al formulario del paso 2
          agregarCamposOcultos();
          cambiarPaso(2);
        }
      });
    });
  }

  // ============================================
  // NAVEGACIÓN ENTRE PASOS
  // ============================================

  // Volver al paso 1
  if (btnVolverPaso2) {
    btnVolverPaso2.addEventListener("click", function () {
      Swal.fire({
        title: "¿Volver al paso anterior?",
        text: "Los datos del paso 2 no se perderán",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, volver",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#6c757d",
        cancelButtonColor: "#090830",
      }).then((result) => {
        if (result.isConfirmed) {
          cambiarPaso(1);
        }
      });
    });
  }

  // Modal de información de cédula
  if (btnInfoCedula) {
    btnInfoCedula.addEventListener("click", function () {
      const modal = new bootstrap.Modal(
        document.getElementById("modalInfoCedula")
      );
      modal.show();
    });
  }

  // ============================================
  // FUNCIONES AUXILIARES
  // ============================================

  // Agregar campos del paso 1 al formulario del paso 2
  function agregarCamposOcultos() {
    // Limpiar campos ocultos previos
    const camposOcultos = formPaso2.querySelectorAll(
      'input[type="hidden"][name^="paso1_"]'
    );
    camposOcultos.forEach((campo) => campo.remove());

    // Agregar nuevos campos ocultos con los datos del paso 1
    const datosPaso1 = new FormData(formPaso1);

    for (let [nombre, valor] of datosPaso1) {
      // No agregar los teléfonos crudos, usaremos los formateados
      if (nombre !== "celular" && nombre !== "whatsapp") {
        const campoOculto = document.createElement("input");
        campoOculto.type = "hidden";
        campoOculto.name = "paso1_" + nombre;
        campoOculto.value = valor;
        formPaso2.appendChild(campoOculto);
      }
    }

    // Agregar teléfonos con formato internacional completo
    if (itiCelular && celular.value.trim() !== "") {
      const celularCompleto = itiCelular.getNumber();
      const celularInput = document.createElement("input");
      celularInput.type = "hidden";
      celularInput.name = "paso1_celular";
      celularInput.value = celularCompleto;
      formPaso2.appendChild(celularInput);
      
      // También guardar el código de país y número por separado si es necesario
      const countryData = itiCelular.getSelectedCountryData();
      const codigoPais = document.createElement("input");
      codigoPais.type = "hidden";
      codigoPais.name = "paso1_codigo_pais";
      codigoPais.value = `+${countryData.dialCode}`;
      formPaso2.appendChild(codigoPais);
    }

    if (itiWhatsapp && whatsapp.value.trim() !== "") {
      const whatsappCompleto = itiWhatsapp.getNumber();
      const whatsappInput = document.createElement("input");
      whatsappInput.type = "hidden";
      whatsappInput.name = "paso1_whatsapp";
      whatsappInput.value = whatsappCompleto;
      formPaso2.appendChild(whatsappInput);
    }
  }

  // Validar campos requeridos del paso 2
  function validarCamposPaso2() {
    let camposValidos = true;
    const camposRequeridos = formPaso2.querySelectorAll(
      "input[required], textarea[required], select[required]"
    );

    for (let campo of camposRequeridos) {
      if (campo.type === "file") {
        if (!campo.files || !campo.files[0]) {
          const label = campo.closest(".form-group")?.querySelector("label");
          const nombreCampo = label
            ? label.textContent.trim().replace("*", "")
            : "este archivo";

          Swal.fire({
            icon: "error",
            title: "Archivo requerido",
            text: `Debe subir el archivo: ${nombreCampo}`,
            confirmButtonColor: "#090830",
          });

          campo.focus();
          camposValidos = false;
          break;
        }
      } else {
        if (!campo.value.trim()) {
          const label = campo.closest(".form-group")?.querySelector("label");
          const nombreCampo = label
            ? label.textContent.trim().replace("*", "")
            : "este campo";

          Swal.fire({
            icon: "error",
            title: "Campo requerido",
            text: `El campo "${nombreCampo}" es obligatorio`,
            confirmButtonColor: "#090830",
          });

          campo.focus();
          camposValidos = false;
          break;
        }
      }
    }

    return camposValidos;
  }

  // ============================================
  // ENVÍO DEL FORMULARIO
  // ============================================

  if (formPaso2) {
    formPaso2.addEventListener("submit", function (e) {
      e.preventDefault();

      // Validar términos y condiciones
      const terminosCheckbox = document.getElementById("terminos");
      if (!terminosCheckbox || !terminosCheckbox.checked) {
        Swal.fire({
          icon: "error",
          title: "Acepte los términos",
          text: "Debe aceptar los términos y condiciones para continuar",
          confirmButtonColor: "#090830",
        });
        return;
      }

      // Validar campos requeridos del paso 2
      if (!validarCamposPaso2()) {
        return;
      }

      // Validar archivos
      let archivosValidos = true;
      const archivos = formPaso2.querySelectorAll('input[type="file"]');

      for (let archivoInput of archivos) {
        if (archivoInput.files && archivoInput.files[0]) {
          if (!validarArchivo(archivoInput)) {
            archivosValidos = false;
            break;
          }
        }
      }

      if (!archivosValidos) return;

      // Mostrar resumen final antes de enviar
      const resumenPaso1 = obtenerResumenPaso1();
      const resumenPaso2 = obtenerResumenPaso2();

      Swal.fire({
        title: "¿Está seguro de enviar el formulario?",
        html: `
          <div class="text-start">
            <p>Revise toda la información antes de enviar:</p>
            
            <div class="card mb-3">
              <div class="card-header bg-light">
                <strong>Datos Personales</strong>
              </div>
              <div class="card-body p-2">
                <table class="table table-sm mb-0">
                  ${resumenPaso1}
                </table>
              </div>
            </div>
            
            <div class="card mb-3">
              <div class="card-header bg-light">
                <strong>Documentación</strong>
              </div>
              <div class="card-body p-2">
                <table class="table table-sm mb-0">
                  ${resumenPaso2}
                </table>
              </div>
            </div>
            
            <div class="alert alert-warning mb-0">
              <i class="fa fa-exclamation-triangle me-2"></i>
              Una vez enviado, no podrá modificar los datos.
            </div>
          </div>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, enviar formulario",
        cancelButtonText: "Editar",
        confirmButtonColor: "#198754",
        cancelButtonColor: "#6c757d",
        width: "700px",
      }).then((result) => {
        if (result.isConfirmed) {
          // Mostrar loading modal
          const loadingModal = new bootstrap.Modal(
            document.getElementById("loadingModal")
          );
          loadingModal.show();

          // Deshabilitar botón para evitar doble envío
          if (btnEnviarFormulario) {
            btnEnviarFormulario.disabled = true;
            btnEnviarFormulario.innerHTML =
              '<i class="fa fa-spinner fa-spin me-2"></i>Enviando...';
          }

          // Enviar formulario
          this.submit();
        }
      });
    });
  }

  // ============================================
  // FUNCIONES PARA RESUMEN
  // ============================================

  function obtenerResumenPaso1() {
    let html = "";
    
    // Obtener datos del formulario paso 1
    const nombres = document.getElementById("nombres")?.value || "";
    const apellidos = document.getElementById("apellidos")?.value || "";
    const correo = document.getElementById("correo")?.value || "";
    const cedulaVal = document.getElementById("cedula")?.value || "";
    
    // Obtener teléfonos formateados
    const celularFormateado = itiCelular
      ? itiCelular.getNumber()
      : celular?.value || "";
    const whatsappFormateado = whatsapp && whatsapp.value && itiWhatsapp
      ? itiWhatsapp.getNumber()
      : "";
    
    html += `
      <tr>
        <td><strong>Nombres:</strong></td>
        <td>${nombres}</td>
      </tr>
      <tr>
        <td><strong>Apellidos:</strong></td>
        <td>${apellidos}</td>
      </tr>
      <tr>
        <td><strong>Cédula:</strong></td>
        <td>${cedulaVal}</td>
      </tr>
      <tr>
        <td><strong>Correo:</strong></td>
        <td>${correo}</td>
      </tr>
      <tr>
        <td><strong>Celular:</strong></td>
        <td>${celularFormateado}</td>
      </tr>
    `;
    
    if (whatsappFormateado) {
      html += `
        <tr>
          <td><strong>WhatsApp:</strong></td>
          <td>${whatsappFormateado}</td>
        </tr>
      `;
    }
    
    return html;
  }

  function obtenerResumenPaso2() {
    let html = "";
    const campos = formPaso2.querySelectorAll(".campo-formulario");

    campos.forEach((campoDiv) => {
      const label = campoDiv.querySelector("label");
      const input = campoDiv.querySelector("input, textarea, select");

      if (label && input) {
        const nombreCampo = label.textContent.replace("*", "").trim();
        let valor = "";

        if (input.type === "file") {
          if (input.files && input.files[0]) {
            valor = `<span class="text-success">
              <i class="fa fa-check-circle me-1"></i>
              ${input.files[0].name} (${formatBytes(input.files[0].size)})
            </span>`;
          } else {
            valor = '<span class="text-muted">No seleccionado</span>';
          }
        } else {
          valor = input.value || '<span class="text-muted">No ingresado</span>';
        }

        html += `
          <tr>
            <td><strong>${nombreCampo}:</strong></td>
            <td>${valor}</td>
          </tr>
        `;
      }
    });

    return html || '<tr><td colspan="2" class="text-center text-muted">Sin datos adicionales</td></tr>';
  }

  function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
  }

  // ============================================
  // INICIALIZACIÓN
  // ============================================

  // Inicializar pasos
  actualizarPasos(1);

  // Configurar eventos para campos dinámicos si existen
  setTimeout(() => {
    if (document.querySelector('input[type="file"]')) {
      setupFilePreviews();
    }
  }, 500);
});