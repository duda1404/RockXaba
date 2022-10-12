<?php

include 'header.php';



if (!isset($_SESSION['logado'])) {

  header('Location: login.php?acao=negado');
}

?>
<!-- partial:index.partial.html -->
<div class="wrapper">
  <div class="profile-card js-profile-card">
    <div class="profile-card__img">
      <img src="uploads/<?php echo $dados['photo_user']; ?>" alt="profile card">
    </div>

    <div class="profile-card__cnt js-profile-cnt">

      <div class="profile-card__name"><p id="nome-pagina-perfil"><?php echo $dados['nome_user']; ?></p></div>

      <?php if(!empty($dados['dsc_user']) or $dados['dsc_user'] != ''){ ?>
      <div class="profile-card__txt"><?php echo $dados['dsc_user']; ?></div>

      <?php } ?>

      <div class="seguindo-notificacoes">
        <div class="artistas-seguidos">
          <p id="titulo-artistas-seguidos"> ARTISTAS SEGUIDOS </p>
          <img id="artistas-logo-seguidos" src="img/limbo7.jpg">
        </div>
        <div class="notificacoes">
          <p id="titulo-notificacoes"> NOTIFICAÇÕES </p>
          <div class="caixa-notificacoes">
            <div class="notificacao">
              <p id="texto-notificacao"> Uma banda que você segue adicionou uma nova imagem! </p>
            </div>
            <div class="notificacao">
              <p id="texto-notificacao"> Um artista que você curtiu adicionou um novo produto na loja! </p>
            </div>
            <div class="notificacao">
              <p id="texto-notificacao"> Um artista que você curtiu adicionou um novo produto na loja! </p>
            </div>
            <div class="notificacao">
              <p id="texto-notificacao"> Um artista que você curtiu adicionou um novo produto na loja! </p>
            </div>
            <div class="notificacao">
              <p id="texto-notificacao"> Um artista que você curtiu adicionou um novo produto na loja! </p>
            </div>
          </div>
        </div>
      </div>
      <div class="ativa-desativa-notificacoes">
        <p id="notificacoes-switch-texto"> Notificações de Artistas </p>
        <label class="switch">
          <input type="checkbox">
          <span class="slider round"></span>
        </label>
        <p id="notificacoes-switch-texto"> Notificações de Eventos </p>
        <label class="switch">
          <input type="checkbox">
          <span class="slider round"></span>
        </label>
      </div>
      <div class="profile-card-ctr">
        <button class="profile-card__button" id="edita-perfil"><a href="editar_perfil.php"> EDITAR PERFIL </button>
        <button class="profile-card__button " id="deleta-conta"><a href="deletar_conta.php"> DELETAR CONTA</button>
        <button class="profile-card__button " id="deleta-conta"><a href=""><img class="seguranca" src="img/lock.png" alt="Segurança e Privacidade"></button>
      </div>
    </div>


    <!-- partial -->
    <script type="text/javascript" src="js/script.js"></script>

    </body>

    </html>