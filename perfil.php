<?php

include 'header.php';



if (!isset($_SESSION['logado'])) {

  header('Location: login.php?acao=negado');
}

?>
<!-- partial:index.partial.html -->

<body class="perfilbody">
  <div class="wrapper">
    <div class="profile-card js-profile-card">
      <div class="profile-card__img">
        <img src="uploads/<?php echo $dados['photo_user']; ?>" alt="profile card">
      </div>

      <div class="profile-card__cnt js-profile-cnt">

        <div class="profile-card__name">
          <p id="nome-pagina-perfil"><?php echo $dados['nome_user']; ?></p>
        </div>

        <?php if (!empty($dados['dsc_user']) or $dados['dsc_user'] != '') { ?>
          <div class="profile-card__txt"><?php echo $dados['dsc_user']; ?></div>

        <?php } ?>

        <div class="profile-card-ctr">
          <button class="profile-card__button" id="edita-perfil"><a href="editar_perfil.php"> EDITAR PERFIL</a> </button>
          <button class="profile-card__button " id="deleta-conta"><a href="javascript:confirmDelete('deletar_conta.php')"> DELETAR CONTA </a></button>
        </div>
      </div>


      <!-- partial -->
      <script type="text/javascript" src="js/script.js"></script>
      <script>
        function confirmDelete(delUrl) {
          if (confirm("Você tem certeza que deseja deletar sua conta? Ela será desativada, junto à sua página de Artista, seus Eventos e seu Perfil.")) {
            document.location = delUrl;
          }
        }
      </script>

</body>

</html>