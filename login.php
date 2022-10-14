<?php

include 'header.php';


/* Se o usuário está logado, redireciona para a página index.php com o método ?acao=negado, que mostra uma mensagem
	informando que precisa sair do perfil para acessar o Login novamente */

if (isset($_SESSION['logado'])) {

	header('Location: index.php?acao=negado');
}

//If que estabelece a condição de que, se o método acao existe (caso o usuário tente acessar uma página
// que requer o Login sem estar logado), ele emite um alert informando que precisa logar antes de acessá-la

if (isset($_GET['acao'])) {

	$acao = $_GET['acao'];

	if ($acao == 'negado') {

		echo '<div class="alert alert-danger" role="alert">
    <strong> Erro!</strong> Você precisa logar para acessar esta página!
  </div>';
	}
}

?>

<?php

//Conexão
//The require_once expression is identical to require except PHP will check if the file has already been included, and if so, not include (require) it again.
require_once 'config.php';

//Inicialização da variável erro
$erroLoginSenha = "";

//se existir o indice btn_entrar , é porque alguém clicou no botão de envio do formulário

if (isset($_POST['btn-entrar'])) :

	//mysqli_escape_string - função que limpa os dados e evita sqlinjection e outros caracteres indevidos.
	$login = pg_escape_string($connect, $_POST['login']);
	$senha = pg_escape_string($connect, $_POST['senha']);


	if (empty($login) or empty($senha)) :

		$erroLoginSenha = "Os campos precisam ser preenchidos";

	else :

		/* Faz uma consulta sql para pegar a situação do usuário (1 - Ativo, 2 - Inativo, 3 - Aguardando Confirmação) e
		a transforma em um item no array $confirmado */

		$confirma_user = pg_query($connect, "SELECT FK_SITUACAO_id_sit FROM usuario WHERE nome_user = '$login'");
		$confirmado = pg_fetch_assoc($confirma_user);

		/* Seleciona, no banco de dados, o nome de usuário igual ao nome de usuário digitado (se ele existe, retorna 1) */

		$resultado = pg_query($connect, "SELECT id_user FROM usuario WHERE nome_user= '$login'");

		/* Seleciona, no banco de dados, a senha criptografada ligada ao nome de usuário igual ao nome de usuário digitado */

		$senhaCriptografada = pg_query($connect, "SELECT senha_user FROM usuario WHERE nome_user = '$login'");

		/* Transforma a senha criptografada ligada ao nome de usuário digitado em um item no array $row */

		$row = pg_fetch_assoc($senhaCriptografada);

		if (!empty($row['senha_user'])) {

			/* Seleciona a senha digitada pelo usuário e a senha criptografada ligada ao nome de usuário por ele digitado no banco de dados, verificando se as duas são compatíveis
			(se sim, retorna TRUE, se não, retorna FALSE) */

			$verificaSenha = password_verify($senha, $row['senha_user']);
		} else {
			$verificaSenha = FALSE;
		}

		//fechando a conexão depois de armazenar os dados

		pg_close($connect);

		//numeros de linhas do resultado da query maior que 0 ou se houver algum registro do nome de usuário na tabela na tabela, $verificaSenha igual a TRUE se a senha digitada é compatível com a senha do banco de dados
		/* Se o nome e senha digitados pelo usuário são compatíveis com nome e senha de um usuário no banco de dados, ele loga no site */

		if ((pg_num_rows($resultado) > 0) && ($verificaSenha == TRUE)) {

			/* Se o usuário não está ativo, envia um alerta pedindo a ele para confirmar sua conta */

			if ($confirmado['fk_situacao_id_sit'] == 3) {

				echo ("<SCRIPT LANGUAGE='JavaScript'>
            	window.alert('Você precisa confirmar sua conta antes de logar no site!');
            	</SCRIPT>");
			}

			/* Se o usuário está ativo, a sessão 'logado' é iniciada */ elseif ($confirmado['fk_situacao_id_sit'] == 1) {

				$dados = pg_fetch_array($resultado);
				$_SESSION['logado'] = true;
				$_SESSION['id_user'] = $dados['id_user'];
				//comando que redireciona para página index.php
				header('Location: index.php');
			} elseif ($confirmado['fk_situacao_id_sit'] == 2) {

				echo ("<SCRIPT LANGUAGE='JavaScript'>

				var x = false;

				if (confirm('Sua conta foi desativada! Deseja reativá-la?') == true){

					window.alert('Conta reativada!');
					window.location.href = 'http://localhost/root/login.php?rt=true'
					
				}
				else{

					window.alert('Faça login com outro email ou reative sua antiga conta para entrar no RockXaba!');
					window.location.href = 'http://localhost/root/login.php?rt=false'
				}
				
            	</SCRIPT>");

				$reativar = filter_input(INPUT_GET, "rt", FILTER_SANITIZE_STRING);
				echo $reativar;

				if (!empty($reativar)) {
				
					if ($reativar == 'true') {
				
						$update = "UPDATE usuario SET FK_SITUACAO_id_sit = 1  WHERE email_user = '$email' AND senha_user = '$senhaCriptografada'";
						$confirma_conta = pg_query($connect, $update);
					}
				}

				
			}
		} else {

			$erroLoginSenha = "Seu login ou senha podem estar errados!";
		}

	endif;
endif;


?>

	

<section class="loginn">

<div class="container-form">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="images/login.jpg" alt="Imagem Login">
        <div class="text">
          <span class="text-1">Cada novo amigo é uma <br> nova aventura</span>
          <span class="text-2">Vamos nos conectar</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="images/register.jpg" alt="Imagem Cadastro">
        <div class="text">
          <span class="text-1">Compelte sua jornada <br> </span>
          <span class="text-2">Vamos começar</span>
        </div>
      </div>
    </div>
    <div class="forms">
      
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="login" placeholder="Digite seu email" >
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password"  name="senha" placeholder="Digite sua senha" >
              </div>
              <div class="text"><a href="#">Esqueceu a senha?</a></div>
              <div class="button input-box">
			  <input type="submit" name="btn-entrar" value="Enviar">
              </div>
              <div class="text sign-up-text">Não tem uma conta? <label for="flip">Inscreva-se agora</label></div>
            </div>
        </form>
      </div>

		</body>

		