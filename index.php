<?php

include 'header.php';

//If que estabelece a condição de que, se o método acao existe (caso o usuário tente acessar a página
// Login estando logado), ele emite um alert informando que precisa sair para acessá-la
/* Método ?acao=sair mostra uma mensagem ao usuário quando ele sai do perfil */

if (isset($_GET['acao'])) {

  $acao = $_GET['acao'];

  if ($acao == 'negado') {

    echo '<div class="alert alert-danger" role="alert">
    <strong> Erro!</strong> Você precisa sair para logar ou se cadastrar novamente!
  </div>';
  } else if ($acao == 'sair') {

    echo '<div class="alert alert-warning" role="alert">
    <strong> Você saiu do seu perfil!</strong> Esperamos que logue novamente
  </div>';
  }
}

?>

<body class="eventos">
  <div class="organiza-evento">
    <div class="titulo">
      <div class="content">
        <h3 id="evento-titulo"> EVENTOS </h3>
      </div>
      <div class="artista-buscar-filtrar">
        <form class=" clearfix searchform">
          <label for="search-box">
            <span class="fa fa-search fa-flip-horizontal fa-2x"></span>
          </label>
          <input type="search" id="search-box" placeholder="Buscar artista, banda, gênero..." />
        </form>
        <div class="select">
          <select name="ORDENAR">
            <option selected disabled value="1">ORDENAR: </option>
            <option value="2">ORDENAR: A-Z</option>
            <option value="3">ORDENAR: LIKES</option>
          </select>
        </div>
      </div>
    </div>
    <a class="link-evento" href="evento_page.php">
      <div class="caixa-de-eventos">
        <img id="imagem-evento" src="img/festival.jpeg" alt="Evento">
        <div class="texto-evento">
          FESTIVAL ORGAS MÃOZINHA
        </div>
      </div>
    </a>
    <a class="link-evento" href="evento_page.php">
      <div class="caixa-de-eventos">
        <img id="imagem-evento" src="img/gotica.jpeg" alt="Evento">
        <div class="texto-evento">
          PIRIGÓTICA FUNK x EMO x POP BR
        </div>
      </div>
    </a>
    <a class="link-evento" href="evento_page.php">
      <div class="caixa-de-eventos">
        <img id="imagem-evento" src="img/DOIDEIRAFEST.jpeg" alt="Evento">
        <div class="texto-evento">
          DOIDERA FEST
        </div>
      </div>
    </a>
  </div>
  </div>

</body>

</html>