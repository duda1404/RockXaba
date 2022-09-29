<?php

  include 'header.php';

//If que estabelece a condição de que, se o método acao existe (caso o usuário tente acessar a página
// Login estando logado), ele emite um alert informando que precisa sair para acessá-la
/* Método ?acao=sair mostra uma mensagem ao usuário quando ele sai do perfil */

if (isset($_GET['acao'])){

  $acao = $_GET['acao'];
  
  if($acao == 'negado'){

    echo '<div class="alert alert-danger" role="alert">
    <strong> Erro!</strong> Você precisa sair para logar ou se cadastrar novamente!
  </div>';
  }

  else if($acao == 'sair'){

    echo '<div class="alert alert-warning" role="alert">
    <strong> Você saiu do seu perfil!</strong> Esperamos que logue novamente
  </div>';

  }

}

?>

   <!-- Seção do Slideshow-->
<section class="carousel" aria-label="carousel" Tabindex="0">
  <a class="carousel__skip-link" href="#skip-link">Carousel überspringen</a>
  <div class="slides">
    <div class="slides-item slide-1" id="slide-1" aria-label="slide 1 of 5" tabindex="0"><img src="./img/orgas.png">1</div>      
    <div class="slides-item slide-2" id="slide-2" aria-label="slide 2 of 5" tabindex="0"><img src="./img/dungeon_fest.png">2</div>
    <div class="slides-item slide-3" id="slide-3" aria-label="slide 3 of 5" tabindex="0">3</div>
    <div class="slides-item slide-4" id="slide-4" aria-label="slide 4 of 5" tabindex="0">4</div>
    <div class="slides-item slide-5" id="slide-5" aria-label="slide 5 of 5" tabindex="0">5</div>       
  </div>
  <div class="carousel__nav">
    <a class="slider-nav" href="#slide-1" aria-label="Go to slide 1"></a>
    <a class="slider-nav" href="#slide-2" aria-label="Go to slide 2"></a>
    <a class="slider-nav" href="#slide-3" aria-label="Go to slide 3"></a>
    <a class="slider-nav" href="#slide-4" aria-label="Go to slide 4"></a>
    <a class="slider-nav" href="#slide-5" aria-label="Go to slide 5"></a>
  </div>

</section>
</body>
</html>