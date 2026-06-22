document.addEventListener("DOMContentLoaded", function () {
  const secciones = [
    { btn: "apostillas", ul: "ul-apostillas" },
    { btn: "convalidaciones", ul: "ul-convalidaciones" },
    { btn: "asesoria", ul: "ul-asesoria" },
    { btn: "atencioncliente", ul: "ul-atencioncliente" },
  ];

  // Ocultar todos los UL inicialmente
  secciones.forEach((sec) => {
    const ul = document.getElementById(sec.ul);
    if (ul) ul.style.display = "none";
  });

  // Agregar eventos
  secciones.forEach((sec) => {
    const btn = document.getElementById(sec.btn);
    const targetUl = document.getElementById(sec.ul);

    if (btn && targetUl) {
      btn.addEventListener("click", function () {
        // Ocultar todos los UL y resetear flechas
        secciones.forEach((s) => {
          const otherUl = document.getElementById(s.ul);
          const otherBtn = document.getElementById(s.btn);
          const otherArrow = otherBtn?.querySelector(".arrow");

          if (otherUl && otherUl !== targetUl) {
            otherUl.style.display = "none";
            if (otherArrow) otherArrow.classList.remove("rotate");
          }
        });

        const arrow = btn.querySelector(".arrow");
        const isVisible = targetUl.style.display === "block";

        // Toggle display
        targetUl.style.display = isVisible ? "none" : "block";

        // Toggle arrow rotation
        if (arrow) {
          arrow.classList.toggle("rotate", !isVisible);
        }
      });
    }
  });

  const swiper = new Swiper(".swiper", {
    // Optional parameters
    direction: "horizontal",
    loop: true,

    // Navigation arrows
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  const swiperAliados = new Swiper(".aliados-swiper", {
    loop: true,
    slidesPerView: 5,
    spaceBetween: 30,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    speed: 3000,
    freeMode: true,
    grabCursor: true,
    breakpoints: {
      320: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      640: {
        slidesPerView: 3,
        spaceBetween: 25,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 30,
      },
    },
  });

  const swiperTestinomios = new Swiper(".testimonios-swiper", {
    loop: true,
    slidesPerView: 3,
    spaceBetween: 40,
    autoplay: {
      delay: 0,
      disableOnInteraction: false, // ❗️Debe estar en false para que no se detenga si el usuario interactúa
    },
    speed: 3000,
    allowTouchMove: false, // ✅ Evita arrastre o swipe manual
    simulateTouch: false, // ✅ Evita que el cursor simule interacción táctil
    grabCursor: false,
    freeMode: false,
    watchOverflow: true,
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 25,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
    },
  });
});

function swicheMenuMobile() {
  const menu = document.querySelector(".menu_mobile");
  if (!menu) return;

  const currentDisplay = getComputedStyle(menu).display;

  if (currentDisplay === "none") {
    menu.style.display = "flex";
    menu.style.flexDirection = "column"; // Opcional para alinear verticalmente
  } else {
    menu.style.display = "none";
  }
}
document
  .getElementById("formApostilla")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    const data = {
      nombres: formData.get("nombres")?.trim(),
      apellidos: formData.get("apellidos")?.trim(),
      celular: formData.get("celular")?.trim(),
      whatsapp: formData.get("whatsapp")?.trim(),
      correo: formData.get("correo")?.trim(),
      cedula: formData.get("cedula")?.trim(),
    };

    // Validación de campos vacíos
    for (const campo in data) {
      if (!data[campo]) {
        Swal.fire({
          icon: "warning",
          title: "Campo obligatorio",
          text: "Por favor completa todos los campos para continuar.",
          confirmButtonText: "Entendido",
        });
        this.querySelector(`[name="${campo}"]`).focus();
        return;
      }
    }

    // Validación de correo
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.correo)) {
      Swal.fire({
        icon: "error",
        title: "Correo inválido",
        text: "Ingresa un correo electrónico válido.",
        confirmButtonText: "Corregir",
      });
      this.querySelector('[name="correo"]').focus();
      return;
    }

    // Mostrar loading
    document.getElementById("loadingApostilla").style.display = "flex";

    // Convertir a JSON y codificar
    const jsonString = JSON.stringify(data);
    const encoded = btoa(unescape(encodeURIComponent(jsonString)));

    // Esperar 3 segundos antes de redirigir
    setTimeout(() => {
      window.location.href = `elegir-pais/?data=${encoded}`;
    }, 3000);
  });

function seleccionarPais(element, base_url) {
    const idPais = element.dataset.id;

    if (!idPais) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo identificar el país seleccionado.",
        });
        return;
    }

    // Unir datos existentes + país
    const dataFinal = {
        ...datosBase,
        id_pais_servicio: idPais,
    };

    // Mostrar loading
    const loading = document.getElementById("loadingApostilla");
    const loadingText = document.getElementById("loadingText");

    loadingText.textContent = "Validando el país seleccionado…";
    loading.style.display = "flex";

    // Convertir a JSON
    const jsonString = JSON.stringify(dataFinal);
    const encoded = btoa(unescape(encodeURIComponent(jsonString)));

    // Delay de 3 segundos antes de redirigir
    setTimeout(() => {
        loadingText.textContent = "Redirigiéndote al siguiente paso…";
        window.location.href = base_url + `elegir-servicio/?data=${encoded}`;
    }, 3000);
}
