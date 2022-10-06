<?php

include 'header.php';

/* Se existir a sessão logado (se o usuário já logou), volta para a página index, com o método ?acao=negado, para
  mostrar uma mensagem ao usuário informando que ele precisa sair do perfil para acessar o cadastro novamente */

if (!isset($_SESSION['logado'])) {


  header('Location: index.php?acao=negado');
}

/* Validação do formulário */

/* Inicialização de variáveis utilizadas na validação */

$erroNome = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {




  /* VALIDA CAMPO USUÁRIO */

  /* Verifica se o campo de usuário está vazio assim que o botão de Enviar formulário (submit) é pressionado, se sim, emite uma mensagem pedindo seu preenchimento */
  if (empty($_POST['nome_artista'])) {

    $erroNome = "Por favor, preencha o nome de usuário";
  } else {

    /* Recebe uma variável nome que é preenchida com o que foi escrito no campo de usuário e chama a função limpaPost*/

    $nome_artista = limpaPost($_POST['nome_artista']);

    /* Verifica se o que foi digitado é um texto válido ou não */
    /* Preg_match - Verifica o que foi inserido na String (nome) e, caso alguma condição seja acionada (! - caso seja falsa), retorna true ou false)*/
    /* Aceita letras minúsculas, maísculas de A até Z, números de 0-9, underline e exige começar com letra*/
  }
}



/* FUNÇÃO QUE IMPEDE A INSERÇÃO DE CÓDIGOS MALICIOSOS NO FORMULÁRIO */

/* Função que limpa o post (informação digitada pelo usuário) impedindo a inserção de códigos maliciosos no formulário*/

function limpaPost($valor)
{

  /* valor - variável qualquer digitada nos campos pelo usuário */
  /* Tira os espaços em branco no início e no final de valor*/
  $valor = trim($valor);
  /* Tira as barras de valor*/
  $valor = stripslashes($valor);
  /* Tira caracteres especiais de html de valor*/
  $valor = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);
  return $valor;
}


/* Verifica se o formulário foi enviado, se sim, salva as informações no Banco de Dados */

if (isset($_POST['btnentrar'])) {


  $photo_name = pg_escape_string($connect, $_FILES["photo"]["name"]);
  $photo_tmp_name = $_FILES["photo"]["tmp_name"];
  $photo_size = $_FILES["photo"]["size"];
  $photo_new_name = rand() . $photo_name;


  $nome_artista = $_POST['nome_artista'];
  $link_play = $_POST['link_play'];
  $dsc_artista = pg_escape_string($connect, $_POST["dsc_artista"]);




  /* Transforma a senha digitada pelo usuário em uma senha criptografada (uma hash, utilizando do algoritmo PASSWORD_DEFAULT) dentro da variável $senha */


  /* Faz uma consulta sql para verificar se o email e/ou o nome digitado pelo usuário já foi cadastrado ou não */

  $verifica_sql = pg_query($connect, "SELECT * FROM artista WHERE nome_artista = '$nome_artista'");

  /* Verifica se o resultado da consulta foi mais de 0, significando que o email e/ou o usuário já foi cadastrado, e informando o usuário sem cadastra-lo no banco de dados */

  if (pg_num_rows($verifica_sql) > 0) {

    echo 'Nome de usuário não disponível!';
  } else {

    /* Se o usuário ainda não foi cadastrado e se não houve erros na validação do formulário, insere seus dados no banco e pede a confirmação
      da conta por email (envia um email pela biblioteca PHPMailer) */

    if (($erroNome == "")) {

      
      /* Gera uma chave criptografada com o email e a data para a confirmação do cadastro via email, pelo usuário */


      /* Insere o cadastro do usuário no Banco de Dados */

      $dat_add_artista = date('Y-m-d H:i:s');

      $sqlArtista = "INSERT INTO artista(nome_artista, link_play, dsc_artista, FK_USUARIO_id_user, dat_add_artista) VALUES ('" . $nome_artista . "','" . $link_play . "','" . $dsc_artista . "','" . $id . "','" . $dat_add_artista . "')";
      $resultado = pg_query($connect, $sqlArtista);

      $result = pg_query($connect, "SELECT id_artista FROM artista WHERE FK_USUARIO_id_user ='$id'");

      $array = pg_fetch_assoc($result);

      $id_artista_FK = $array['id_artista'];

      $sqlFotosArtista = "INSERT INTO foto_artista(photo_artista, FK_ARTISTA_id_artista) VALUES ('" . $photo_new_name . "', '" . $id_artista_FK . "')";
      $sqlInsereDados = pg_query($connect, $sqlFotosArtista);

      move_uploaded_file($photo_tmp_name, "uploads/" . $photo_new_name);


      $seletor = $_POST[('meu-select')];

      switch ($seletor) {

        case 1:
         
          $sqlComando1 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 1, '" . $id_artista_FK . "')");
         
          break;
        case 2:
      
          $sqlComando2 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 2, '" . $id_artista_FK . "')");
          break;
        case 3:
          
          $sqlComando3 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 3, '" . $id_artista_FK . "')");
          break;
        case 4:
          
          $sqlComando4 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 4, '" . $id_artista_FK . "')");
          break;
        case 5:

          $sqlComando5 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 5, '" . $id_artista_FK . "')");
          break;
        case 6:

          $sqlComando6 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 6, '" . $id_artista_FK . "')");

          break;

          case 6:

            $sqlComando6 = pg_query($connect, "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ( 7, '" . $id_artista_FK . "')");
  
            break;
      }

      header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
      exit();

      
      //fechando a conexão depois de armazenar os dados




    }
  }
}

?>

<section class="cadastro">
  <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

    <h1> Cadastro </h1>

    <!-- php echo, no span, emite as mensagens de erro (caso ocorram) embaixo de cada campo -->
    <!-- php do if(isset) estabelece a condição de caso o POST existir (isset) o valor do input será novamente preenchido com as informações antes digitadas pelo usuário  -->
    <!-- php if(!empty) estabelece a condição de caso as variáveis de erro não sejam vazias (e, portanto, haja erros nos campos digitados pelo usuário), será criada uma classe inválido, 
    referente ao input, permitindo que a sombra do elemento fique vermelha -->


    <label class="form-group">
      <input type="text" name="nome_artista" <?php if (!empty($erroNome)) {
                                                echo "class='invalido'";
                                              } ?> <?php if (isset($_POST['nome_artista'])) ?> placeholder="Artista" required>
      <span class="erro"><?php echo $erroNome; ?></span>

      <span class="border"></span>
    </label>

    <label class="form-group">
      <input type="text" id="link_play" name="link_play" class="form-control" <?php if (isset($_POST['link_play'])) ?> placeholder="Link do Spotify" required>

      <span class="border"></span>
    </label>

    <label class="form-group">
      <input type="text" id="dsc_artista" name="dsc_artista" class="form-control" <?php if (isset($_POST['dsc_artista'])) ?> placeholder="Descrição" required>

      <span class="border"></span>
    </label>


    <label class="form-group">

      <img class="photo_img" src="uploads/<?php echo $row["photo"]; ?>">
      <label for="photo" class="img"> Clique aqui para enviar a foto de perfil </label>
      <input type="file" accept="image/*" id="photo" name="photo">
    </label>


    <button type="submit" name="btnentrar"> Concluir</button>

    <a href="login.php">
      <input type="button" name="voltar_login" value="Voltar">
    </a>

  </form>
  <section>
    </body>


    </html>