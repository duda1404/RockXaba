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
    </div>
    <div id="imprime-evento">
      <?php

date_default_timezone_set('America/Sao_Paulo');

// Then call the date functions
$date = date('Y-m-d H:i:s');
  

      /*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
      $image_query = pg_query($connect, "select even.id_evento, even.nome_evento,
    foto.photo_evento from evento even inner join usuario userr on even.fk_usuario_id_user = userr.id_user inner join artista art on art.fk_usuario_id_user = userr.id_user inner join
    foto_evento foto on foto.fk_evento_id_evento = even.id_evento where even.fk_situacao_id_sit = 1 and art.fk_situacao_id_sit = 1 and foto.front_page = 'front' and CURRENT_DATE < even.dat_evento + INTERVAL '7 days'");
      while ($rows = pg_fetch_array($image_query)) {
        $id_evento = $rows['id_evento'];
        $nome_evento = $rows['nome_evento'];
        $photo = $rows['photo_evento'];



      ?>


        <a class="link-evento" href="evento_page.php?myid=<?php echo $id_evento; ?>" id="link">
          <div class="caixa-de-eventos" id="caixa-evento" title="<?php echo $nome_evento; ?>">
            <img id="imagem-evento" src="uploads/<?php echo $photo; ?>" alt="Evento" title="<?php echo $nome_evento; ?>">
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
  </div>

</body>

</html>