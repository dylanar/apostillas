<section class="contactanos_home">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div class="texto">
        <h3 class="titulo_sm">Contáctanos</h3>

        <p class="textCMb">
          En Apostilla y Legalizaciones, te ofrecemos una atención
          personalizada y eficiente, adaptada a tus necesidades y objetivos
          académicos. A diferencia de las empresas que usan sistemas
          automáticos, nuestro equipo de expertos está aquí para brindarte
          un servicio humano y especializado.
        </p>

        <p class="textCMb">
          Cada caso es único, por lo que trabajamos para entender tus
          requerimientos y ofrecerte soluciones precisas.
        </p>

        <p><strong>¿Cómo puedes contactarnos?</strong></p>

        <p class="icon"><i class="fa fa-phone"></i> +57 3005023755</p>
        <p class="icon">
          <i class="fa fa-envelope"></i>
          tramiteslegalesyapostillas@gmail.com
        </p>
        <p class="icon"><i class="fa fa-brands fa-whatsapp"></i> +57 3005023755</p>

        <p class="icon"><i class="fa fa-map-marker"></i> Cra 61B #72-38, Nte. Centro Historico,
          Barranquilla, Atlántico</p>, 
      </div>

      <div class="video">
        <div class="youtube-lazy" data-id="wSCPLOpzcXs">
          <div class="youtube-thumb" style="background-image:url('<?= ASSETS_URL; ?>/img/footervideo.png')">
          </div>
        </div>
      </div>

    </div>

    <div class="mapa">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.464723973139!2d-74.795855!3d11.003717000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8ef42d9c5d2a1c89%3A0x673c492ed81eb0bb!2sCra.%2061b%20%23%2072-38%2C%20Nte.%20Centro%20Historico%2C%20Barranquilla%2C%20Atl%C3%A1ntico!5e0!3m2!1ses-419!2sco!4v1777071603133!5m2!1ses-419!2sco"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    
    </div>
  </div>
</section>

<footer>
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <div class="derechos">
      <p>
        Copyright © 2019 Apostillas y convalidaciones SAS Todos los
        Derechos Reservados.
      </p>
    </div>
    <div class="redes d-flex align-items-center">
      <a href="https://www.facebook.com/profile.php?id=61564114493683&mibextid=LQQJ4d&rdid=RzLPosDnk3Q7LJxd&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2FdcJaQAFkiMVUYWPL%2F%3Fmibextid%3DLQQJ4d#"
        class="fb" aria-label="Ir a Facebook"><i class="fa-brands fa-facebook"></i>
        <span class="visually-hidden">Facebook</span></a>

      <a href="https://www.instagram.com/apostillasylegalizaciones.es?igsh=MW9oMzVrczNzdHBrMQ%3D%3D" class="it"
        aria-label="Ir a instagram"><i class="fa-brands fa-instagram"></i>
        <span class="visually-hidden">instagram</span></a>

      <a href="https://www.youtube.com/@ApostillasyLegalizacionesSAS" class="yt" aria-label="Ir a youtube"><i class="fa-brands fa-youtube"></i>
        <span class="visually-hidden">youtube</span></a>

      <a href="tramiteslegalesyapostillas@gmail.com" class="mail" aria-label="Ir a gmail"><i class="fa fa-envelope"></i>
        <span class="visually-hidden">gmail</span></a>
    </div>
  </div>
</footer>

<a href="https://api.whatsapp.com/send/?phone=573005023755&text=Hola%21%20Necesito%20apostillar%20mis%20documentos%20%F0%9F%87%A8%F0%9F%87%B4"
  target="_blank" class="wpp <?php if($_GET['action'] === 'credito' ){echo 'no-wpp-mobile';} ?>">
  <img src="<?= ASSETS_URL; ?>/img/wpp.svg" alt="whatsapp" width="60" height="60" aria-label="Chatear por whatsapp" />
</a>
</body>


<!-- Modal -->
<div class="modal fade" id="metodopagos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zona de Pagos Seguros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="<?= ASSETS_URL; ?>/img/zonapagos.webp" loading="lazy" alt="" style="width: 100%; height: auto;">
      </div>
    </div>
  </div>
</div>
