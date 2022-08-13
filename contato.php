<?php

/* Inclui o header e a conexão com o Banco de Dados */

include 'header.php';

/* Se a sessão logado não existe, ou seja, se o usuário não logou ainda, ele é redirecionado à página de Login 
  com o método ?acao=negado, mostrando-o uma mensagem que informa que precisa logar para acessar a página de Suporte */ 

  if (!isset($_SESSION['logado'])):
    header('Location: login.php?acao=negado');
  endif;

/* Validação do formulário */  

/* Inicialização de variáveis utilizadas na validação */

$erroMensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){


    /* VALIDA CAMPO MENSAGEM */

    if(empty($_POST['mensagem'])){

      $erroMensagem = "Por favor, digite sua mensagem";

  }
  
  else{

      /* Inicializa uma variável mensagem que é preenchida com o que foi escrito no campo de mensagem e chama a função limpaPost*/

      $mensagem = limpaPost($_POST['mensagem']);

  }
    


    /* Emite um alerta em JavaScript caso o formulário seja preenchido e enviado sem erros, informando ao usuário seu envio */

    if(($erroMensagem == "")) {

      $emailEnvia = $dados['email_user'];
      $apelidoEnvia = $dados['nome_user'];
      $emailRecebe = 'rockxaba@gmail.com';
      $apelidoRecebe = 'RockXaba';

      $body = "Mensagem enviada por usuário para fins de Suporte: <br>
        ID: ".$dados['id_user']."<br>
        Nome: ".$dados['nome_user']."<br>
        Email: ".$dados['email_user']."<br>
        Mensagem: ".$mensagem;

        $assunto = 'Suporte';

      include 'emails.php';
  
    } 
  }

/* FUNÇÃO QUE IMPEDE A INSERÇÃO DE CÓDIGOS MALICIOSOS NO FORMULÁRIO */

  /* Função que limpa o post (informação digitada pelo usuário) impedindo a inserção de códigos maliciosos no formulário*/

  function limpaPost($valor){
    
    /* valor - variável qualquer digitada nos campos pelo usuário */
    /* Tira os espaços em branco no início e no final de valor*/
    $valor = trim($valor);
     /* Tira as barras de valor*/
    $valor = stripslashes($valor);
     /* Tira caracteres especiais de html de valor*/
     $valor = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);
    return $valor;
}

/* INSERINDO MENSAGENS NO BANCO DE DADOS */

if(isset($_POST['btnenviar'])){

  require 'config.php';

  $emailUser = $dados['email_user'];
  $id_user_FK = $dados['id_user'];
  $data = date('Y-m-d H:i:s');
  $suporteSql = "INSERT INTO suporte(dsc_msg, data_msg, FK_USUARIO_id_user) VALUES ('" . $mensagem . "','". $data. "','" . $id_user_FK . "')";
  $incluiSuporte = mysqli_query($connect, $suporteSql);

  //fechando a conexão depois de armazenar os dados

  mysqli_close($connect);
		


}

?>

<section class="contato">
 <!--Seção do contato, contendo o formulário a ser preenchido -->
  
  <form class="formulario" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

   <h1> Suporte </h1>

    <!-- php echo, no span, emite as mensagens de erro (caso ocorram) embaixo de cada campo -->
    <!-- php do if(isset) estabelece a condição de caso o POST existir (isset) o valor do input será novamente preenchido com as informações antes digitadas pelo usuário  -->
    <!-- php if(!empty) estabelece a condição de caso as variáveis de erro não sejam vazias (e, portanto, haja erros nos campos digitados pelo usuário), será criada uma classe inválido, 
    referente ao input, permitindo que a sombra do elemento fique vermelha --> 

    <input type="text" name="nome" <?php echo "value='".$dados['nome_user']."'";?> placeholder="Usuário" disabled="disabled">

      <input type="email" name="email" <?php echo "value='".$dados['email_user']."'";?> placeholder="Email" disabled="disabled">

      <textarea rows="10" cols="25" name="mensagem" <?php if(!empty($erroMensagem)){echo "class='invalido'";}?> <?php if(isset($_POST['mensagem'])){echo "value='".$_POST['mensagem']."'";} ?> placeholder="Mensagem" required></textarea>
      <span class="erro"><?php echo $erroMensagem; ?></span>

      <button type="submit" name="btnenviar"> Enviar</button>

</form>
</body>
</section>
</html>
