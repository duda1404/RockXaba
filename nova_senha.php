<?php 

include 'header.php';

/* Inclui conexão com o Banco de Dados */

require 'config.php';

/* Filtro que pega a variável chave da URL e a sanitiza*/

$chave = filter_input(INPUT_GET, "chave", FILTER_SANITIZE_STRING);

/* VALIDA CAMPO SENHA */

$erroSenha = "";
$erroRepeteSenha = "";
$verifica_chave = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

if(empty($_POST['senha'])){

    $erroSenha = "Por favor, preencha sua senha";

}

  else{

        /* Recebe uma variável senha que é preenchida com o que foi escrito no campo de Senha e chama a função limpaPost*/

        $senha = limpaPost($_POST['senha']);

        /* Verifica se o que foi digitado é uma senha válida ou não */
        /* strlen - verifica o tamanho da variável (senha) digitada*/
        /* Caso a senha tenhos que 6 dígitos, emite uma mensagem de erro*/
        
        if(strlen($senha) < 6){

            $erroSenha = "A senha precisa ter, no mínimo, 6 dígitos";

  }

  /* VALIDA CAMPO REPETE SENHA */

  if(empty($_POST['repeteSenha'])){

      $erroRepeteSenha = "Por favor, preencha novamente sua senha";

  }

    else{

          /* Recebe uma variável repeteSenha que é preenchida com o que foi escrito no campo de repeteSenha e chama a função limpaPost*/

          $repeteSenha = limpaPost($_POST['repeteSenha']);

          /* Verifica se a senha digitada é igual à senha digitada no campo Senha, caso contrário, preenche a variável de erro com uma mensagem informando o problema*/
          
          if($repeteSenha != $senha){

              $erroRepeteSenha = "A senha está diferente da digitada anteriormente!";

    }
      
  } 

}}

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

if (!empty($chave)){

    /* Faz uma consulta sql para encontrar o id_user do usuário cuja chave seja igual à chave presente na URL, e transforma esse
    id em um item do $array. Se existe algum id_user que preenche esses requisitos, muda a situação do usuário para 'Ativo'
    no Banco de Dados, e coloca sua chave como NULL (nula) para que não possa utilizá-la mais de uma vez, confirmando sua conta novamente */

    $verifica_chave = mysqli_query($connect, "SELECT id_user FROM usuario WHERE chave_recupera_senha = '$chave' LIMIT 1");
    $array = $verifica_chave->fetch_assoc();
}
else{
    
    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Houve um erro! Chave vazia!');
        window.location('index.php');
        </SCRIPT>");

}

/* Verifica se o formulário foi enviado, se sim, salva as informações no Banco de Dados */

if (isset($_POST['btnentrar'])){

    if (mysqli_num_rows($verifica_chave)>0){

         /* Transforma a senha digitada pelo usuário em uma senha criptografada (uma hash, utilizando do algoritmo PASSWORD_DEFAULT) dentro da variável $senha */

        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);    

        /* Update da situação da senha antiga para a senha nova */

        $updateSenha = "UPDATE usuario SET senha_user = '".$senha."'  WHERE id_user = '".$array['id_user']."'";
        $confirmaSenha = mysqli_query($connect, $updateSenha);

        $deleta_chave =  "UPDATE usuario SET chave_recupera_senha = NULL WHERE id_user = '".$array['id_user']."'";
        $deletando = mysqli_query($connect, $deleta_chave);

        //fechando a conexão depois de atualizar os dados

		mysqli_close($connect);

        if($confirmaSenha){

            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Senha atualizada! Faça o login para entrar em seu perfil!');
            window.location.href='login.php';
            </SCRIPT>");
        }
        else{

            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Erro de atualização da senha!');
            </SCRIPT>");

        }

    }
    else{

        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Erro! Endereço Inválido!');
        </SCRIPT>");

    }

} 


?>

<section class="novaSenha">
<form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <h1> Nova Senha </h1>

    <!-- php echo, no span, emite as mensagens de erro (caso ocorram) embaixo de cada campo -->
    <!-- php do if(isset) estabelece a condição de caso o POST existir (isset) o valor do input será novamente preenchido com as informações antes digitadas pelo usuário  -->
    <!-- php if(!empty) estabelece a condição de caso as variáveis de erro não sejam vazias (e, portanto, haja erros nos campos digitados pelo usuário), será criada uma classe inválido, 
    referente ao input, permitindo que a sombra do elemento fique vermelha -->


    <input type="password" name="senha" <?php if(!empty($erroSenha)){echo "class='invalido'";}?> <?php if(isset($_POST['senha'])){echo "value='".$_POST['senha']."'";} ?> placeholder="Senha" required>
    <span class="erro"><?php echo $erroSenha; ?></span>

    <input type="password" name="repeteSenha" <?php if(!empty($erroRepeteSenha)){echo "class='invalido'";}?> <?php if(isset($_POST['repeteSenha'])){echo "value='".$_POST['repeteSenha']."'";} ?> placeholder="Repita a senha" required>
    <span class="erro"><?php echo $erroRepeteSenha; ?></span><br>

    <button type="submit" name="btnentrar"> Concluir </button>

    </form>
  <section>
</body>

