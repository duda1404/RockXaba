<?php
include 'header.php'
?>

   <!-- Seção do Slideshow, sendo cada slide uma classe, e cada classe contendo uma imagem-->
  <section class="principal">

  <div class="slideshow-container">
    <div class="mySlides fade">
      <img src="./img/1.jpg" style="width:100%">
    </div>

    <div class="mySlides fade">
      <img src="./img/2.jpg" style="width:100%">
    </div>

    <div class="mySlides fade">
      <img src="./img/3.jpg" style="width:100%">
    </div>

     <!--Botões de Anterior e Próximo -->
    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>

  </div>
 
   <!-- Indicadores da parte de baixo do Slideshow -->
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>

  <script type="text/javascript" src="js/script.js"></script>

</body>
</html>