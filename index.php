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

   <!-- Seção do Slideshow, sendo cada slide uma classe, e cada classe contendo uma imagem-->
   <div class="carousel">
  <div class="progress-bar progress-bar--primary hide-on-desktop">
    <div class="progress-bar__fill"></div>
  </div>

<header class="main-post-wrapper">
  
  <div class="slides">
    <article class="main-post main-post--active">
      <div class="main-post__image">
        <img src="img/1.jpg" alt="New McLaren wind tunnel 'critical' to future performance, says Tech Director Key" />
      </div>
      <div class="main-post__content">
        <div class="main-post__tag-wrapper">
          <span class="main-post__tag">News</span>
        </div>
        <h1 class="main-post__title">New McLaren wind tunnel 'critical' to future performance, says Tech Director Key</h1>
        <a class="main-post__link" href="#">
              <span class="main-post__link-text">find out more</span>
              <svg
                class="main-post__link-icon main-post__link-icon--arrow"
                width="37"
                height="12"
                viewBox="0 0 37 12"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11"
                  stroke="white"
                />
              </svg>
            </a>
      </div>
    </article>
    <article class="main-post main-post--not-active">
      <div class="main-post__image">
        <img src="img/2.jpg" alt="What To Watch For in the 2019 Hungarian Grand Prix" />
      </div>
      <div class="main-post__content">
        <div class="main-post__tag-wrapper">
          <span class="main-post__tag">Video</span>
        </div>
        <h1 class="main-post__title">What To Watch For in the 2019 Hungarian Grand Prix</h1>
        <a class="main-post__link" href="#">
              <svg
                class="main-post__link-icon main-post__link-icon--play-btn"
                width="30"
                height="30"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle
                  cx="10"
                  cy="10"
                  r="9"
                  stroke="#C20000"
                  stroke-width="2"
                />
                <path d="M14 10L8 6V14L14 10Z" fill="white" />
              </svg>
              <span class="main-post__link-text">play video</span>
            </a>
      </div>
    </article>
    <article class="main-post main-post--not-active">
      <div class="main-post__image">
        <img src="img/3.jpg" alt="Hamilton wants harder championship fight from Leclerc and
            Verstappen" />
      </div>
      <div class="main-post__content">
        <div class="main-post__tag-wrapper">
          <span class="main-post__tag">News</span>
        </div>
        <h1 class="main-post__title">Hamilton wants harder championship fight from Leclerc and Verstappen
        </h1>
        <a class="main-post__link" href="#">
              <span class="main-post__link-text">find out more</span>
              <svg
                class="main-post__link-icon main-post__link-icon--arrow"
                width="37"
                height="12"
                viewBox="0 0 37 12"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0 6H36.0001M36.0001 6L31.0001 1M36.0001 6L31.0001 11"
                  stroke="white"
                />
              </svg>
            </a>
      </div>
    </article>
  </div>
</header>

<div class="posts-wrapper hide-on-mobile">
  <article class="post post--active">
    <div class="progress-bar">
      <div class="progress-bar__fill"></div>
    </div>
    <header class="post__header">
      <span class="post__tag">News</span>
      <p class="post__published">16 August 2019</p>
    </header>
    <h2 class="post__title">New McLaren wind tunnel 'critical' to future performance, says Tech Director Key</h2>
  </article>
  <article class="post">
    <div class="progress-bar">
      <div class="progress-bar__fill"></div>
    </div>
    <header class="post__header">
      <span class="post__tag">Video</span>
      <p class="post__published">12 August 2019</p>
    </header>
    <h2 class="post__title">What To Watch For in the 2019 Hungarian Grand Prix</h2>
  </article>
  <article class="post">
    <div class="progress-bar">
      <div class="progress-bar__fill"></div>
    </div>
    <header class="post__header">
      <span class="post__tag">News</span>
      <p class="post__published">08 August 2019</p>
    </header>
    <h2 class="post__title">Hamilton wants harder championship fight from Leclerc and Verstappen
    </h2>
  </article>
</div>
</div>
<main style="min-height: 100vh; background: black;"></main>

  <script type="text/javascript" src="js/script.js"></script>

</body>
</html>