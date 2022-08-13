<?php

include 'header.php';
require_once 'config.php';

if(isset($_SESSION['logado'])){

    header('Location: index.php');


}

$erroEmail = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  /* VALIDA CAMPO EMAIL */

  /* Verifica se o campo de email está vazio assim que o botão de Enviar formulário (submit) é pressionado, se sim, preenche uma variável com uma mensagem pedindo seu preenchimento */  
  if(empty($_POST['email'])){

      $erroEmail = "Por favor, informe um email";

  }
  
  else{

      /* Recebe uma variável email que é preenchida com o que foi escrito no campo de email e chama a função limpaPost*/

      $email = limpaPost($_POST['email']);

      /* Verifica se o que foi digitado é um email válido ou não. Caso seja diferente de válido, coloca uma mensagem de erro dentro da variável $erroEmail */

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $erroEmail = "Email inválido!";

      }
    

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

if (isset($_POST['btnenviar'])){

  /* Verificando se o email já existe no banco de dados */
      
  $verifica_email = mysqli_query($connect, "SELECT * FROM usuario WHERE email_user = '$email'");

  /* Se o email já existe no banco de dados, informa ao usuário */

  if (mysqli_num_rows($verifica_email) > 0){

      $_SESSION['recuperando'] = TRUE;

        /* Gera uma chave criptografada com o email e a data para a requisição de uma nova senha via email, pelo usuário */

        $chave = password_hash($_POST['email'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario(chave_recupera_senha) VALUES ('" . $chave . "')";
        $resultado = mysqli_query($connect,$sql);

        $emailEnvia = 'rockxaba@gmail.com';
        $apelidoEnvia = 'RockXaba';
        $emailRecebe = $_POST['email'];
        $apelidoRecebe = '';

        $body = "Este email diz respeito à <strong> requisição de uma nova senha, </strong> 
        no site RockXaba. Clique no link abaixo para realizá-la: <br>
        <a href='http://localhost/root/nova_senha.php?chave=$chave''> Clique aqui </a>";

        $assunto = 'Recuperando Senha';

        include 'emails.php';

        mysqli_close($connect);
      

    }

    else{

      $erroEmail = "Este email não está cadastrado!<br>";


    }

}


?>

<section class="recuperaSenha">

 <!--Seção do formulário de Recuperação de Senha, contendo o formulário a ser preenchido -->
  
  <form class="formulario" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

   <h1> Recuperar Senha </h1>

    <!-- php echo, no span, emite as mensagens de erro (caso ocorram) embaixo do campo -->
    <!-- php if(!empty) estabelece a condição de caso as variáveis de erro não sejam vazias (e, portanto, haja erros nos campos digitados pelo usuário), será criada uma classe inválido, 
    referente ao input, permitindo que a sombra do elemento fique vermelha --> 
     
    <input type="email" name="email" <?php if(!empty($erroEmail)){echo "class='invalido'";}?> placeholder="Email" required>
    <span class="erro"><?php echo $erroEmail; ?></span>

      <button class="button" type="submit" name="btnenviar"> Enviar </button>

</form>
</body>
</section>
</html>