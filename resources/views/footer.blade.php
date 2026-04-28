<footer class="footer">
  <div class="footer-container">

    <!-- LOGO + DESCRIPCIÓN -->
    <div class="footer-col">
      <img src="{{ asset('img/elelogo2.webp') }}" alt="Logo Elenex" class="footer-logo">

      <p class="footer-text">
        Somos una empresa peruana de moda urbana y casual que combina diseño moderno,
        calidad y autenticidad en cada prenda, pensada para quienes buscan destacar con estilo.
      </p>

      <a href="{{ route('reclamaciones.create') }}">
          <img src="{{ asset('img/libror.webp') }}" alt="Libro de Reclamaciones" class="libro-img">
      </a>
    </div>

    <!-- CONTACTO -->
    <div class="footer-col">
      <h3 class="conta">Contáctanos</h3>
      <ul>
        <li><i class="fas fa-clock" style="color:#fff;"></i> Lunes a viernes: 9:00 a.m. - 6:00 p.m.</li>
        <li><i class="fas fa-envelope" style="color:#fff;"></i> ventasonline@elenexperu.com</li>
        <li><i class="fa-brands fa-whatsapp" style="color:#fff;"></i> +51 933 857 924</li>
        <li><i class="fas fa-store" style="color:#fff;"></i> 
          <a href="{{ route('tiendas.index') }}">Nuestras tiendas</a>
        </li>
      </ul>
    </div>

    <!-- REDES SOCIALES -->
    <div class="footer-col">
      <h3 class="sig">Síguenos</h3>
      <div class="social-icons">
        <a href="https://www.facebook.com/elenexpe" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://www.instagram.com/elenex_pe/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/@elenex_pe" target="_blank"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>

    <!-- MÉTODOS DE PAGO (CULQI STYLE) -->
    <div class="footer-col">
      <h3>Métodos de pago</h3>

      <div class="payment-logos">
        <img src="{{ asset('img/visa.svg') }}" alt="Visa">
        <img src="{{ asset('img/mastercard.svg') }}" alt="Mastercard">
        <img src="{{ asset('img/diners.svg') }}" alt="Diners Club">
        <img src="{{ asset('img/pagoefectivo.svg') }}" alt="Pago Efectivo">
        <img src="{{ asset('img/yape.svg') }}" alt="Yape">
        <img src="{{ asset('img/plin.svg') }}" alt="Plin">
      </div>
    </div>

  </div>

  <!-- COPYRIGHT -->
  <div class="footer-bottom">
    <p>Copyright &copy; {{ date('Y') }} ELENEX | Todos los derechos reservados.</p>

    <div>
      <a href="/terminos">Términos y condiciones</a>
      <a href="/preguntas">Preguntas frecuentes</a>
      <a href="/politica">Politica de privacidad</a>
    </div>
  </div>
</footer>