<footer class="footer">
  <div class="footer-container">

    <!-- Logo a la izquierda -->
    <div class="footer-logo">
      <img src="{{ asset('img/elelogo2.png') }}" alt="Logo Elenex">

    <!-- Contenido sobre nosotros -->
      <div class="footer-about">
        <p>Somos una empresa peruana de moda urbana y casual,</p> 
          <p>combina diseño moderno, calidad y autenticidad </p>
          <p>en cada prenda, pensada para quienes</p> 
          <p>buscan destacar con estilo.</p>
      </div>

    <!-- Libro de reclamaciones -->
      <div class="footer-libro">
    <img src="{{ asset('img/libror.png') }}" alt="Libro de Reclamaciones">
  </div>
    </div>

    <!-- Contacto -->
      <div class="footer-contact">
        <h2>CONTACTANOS</h2>
        <p><i class="fas fa-comments"></i> Chatea con nosotros</p>
        <span>Lunes a viernes de 9:00 a.m. - 6:00 p.m.</span> 
        <p><i class="fas fa-envelope"></i> Escríbenos</p>
        <span>ventasonline@elenexperu.com</span> 
        <p><i class="fas fa-phone"></i> Llamános</p>
        <span>+51 123 456 789</span>
        <p><i class="fas fa-store"></i>
        <a href="{{ route('tiendas.index') }}">Nuestras Tiendas</a></p>
      </div>

    <!-- Redes sociales + Metodos de pago -->
     <div class="footer-right">
      <div class="footer-social">
        <h2>SIGUENOS</h2>
        <div class="social-icons">
          <a href="https://www.facebook.com/elenexpe" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
          <a href="https://www.instagram.com/elenex_pe/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
          <a href="https://www.tiktok.com/@elenex_pe" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i></a>
        </div>
      </div>

       <div class="footer-pago">
        <h2>METODOS DE PAGO</h2>
        <br>
        <a href="#">VISA</a> |
        <a href="#">MASTERCARD</a> |
        <a href="#">DINNERS CLUB</a>
        <br>
        <a href="#">MASTERCARD</a> |
        <a href="#">PAGO EFECTIVO</a> |
        <a href="#">YAPE</a> 
      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="footer-copy">
    <div class="copy-left">
    Copyright &copy; {{ date('Y') }} ELENEX | Todos los derechos reservados.
</div>

    <div class="copy-right">
    <a href="/terminos">Términos y condiciones</a>
    <a href="/preguntas">Preguntas frecuentes</a>
    <a href="/politica">Politica de privacidad</a>
  </div>
</div>
</footer>