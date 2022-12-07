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
        <div class="lupa">
          <img src="img/lupa.png" class="lupa-de-busca">
        </div>
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
    <?php
    /*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
    $image_query = pg_query($connect, "select even.id_evento, even.nome_evento, 
      even.dsc_evento, even.google_maps, even.local_evento, even.dat_evento, even.dat_limite_ingresso, even.dat_inicio_ingresso, even.cor_evento,
      even.artistas, foto_evento.photo_evento, foto_evento.front_page from evento even inner join
      foto_evento foto_evento on even.id_evento = foto_evento.fk_evento_id_evento where even.fk_situacao_id_sit = 1 and foto_evento.front_page = 'front' order by even.dat_add_evento desc");
    while ($rows = pg_fetch_array($image_query)) {
      $id_evento = $rows['id_evento'];
      $nome_evento = $rows['nome_evento'];
      $photo = $rows['photo_evento'];
      $dsc_evento = $rows['dsc_evento'];

    ?>

      <a class="link-evento" href="evento_page.php?event_id=<?php echo $id_evento; ?>">
        <div class="caixa-de-eventos">
          <img id="imagem-evento" src="uploads/<?php echo $photo; ?>" alt="Evento">
          <div class="texto-evento">
            <?php echo strtoupper($nome_evento); ?>
          </div>
        </div>
      </a>
    <?php
    }
    ?>

  </div>
  </div>

</body>

</html>