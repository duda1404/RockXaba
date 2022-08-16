<?php

include 'header.php';


/* Se o usuário está logado, redireciona para a página index.php com o método ?acao=negado, que mostra uma mensagem
	informando que precisa sair do perfil para acessar o Login novamente */

if (isset($_SESSION['logado'])){

	header('Location: index.php?acao=negado');

}

//If que estabelece a condição de que, se o método acao existe (caso o usuário tente acessar uma página
// que requer o Login sem estar logado), ele emite um alert informando que precisa logar antes de acessá-la

if (isset($_GET['acao'])){

  $acao = $_GET['acao'];
  
  if($acao == 'negado'){

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

if (isset($_POST['btn-entrar'])):

	//mysqli_escape_string - função que limpa os dados e evita sqlinjection e outros caracteres indevidos.
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);
	
	
	if(empty($login) or empty($senha)):

		$erroLoginSenha = "Os campos precisam ser preenchidos";

	else:

		/* Faz uma consulta sql para pegar a situação do usuário (1 - Ativo, 2 - Inativo, 3 - Aguardando Confirmação) e
		a transforma em um item no array $confirmado */

		$confirma_user = mysqli_query($connect, "SELECT FK_SIT_USUARIO_id_sit FROM usuario WHERE nome_user = '$login'");
		$confirmado = $confirma_user->fetch_assoc();

		/* Seleciona, no banco de dados, o nome de usuário igual ao nome de usuário digitado (se ele existe, retorna 1) */

		$resultado = mysqli_query($connect,"SELECT id_user FROM usuario WHERE nome_user= '$login'");

		/* Seleciona, no banco de dados, a senha criptografada ligada ao nome de usuário igual ao nome de usuário digitado */

		$senhaCriptografada = mysqli_query($connect, "SELECT senha_user FROM usuario WHERE nome_user = '$login'");

		/* Transforma a senha criptografada ligada ao nome de usuário digitado em um item no array $row */

		$row = $senhaCriptografada->fetch_assoc();

		if (!empty($row['senha_user'])){

			/* Seleciona a senha digitada pelo usuário e a senha criptografada ligada ao nome de usuário por ele digitado no banco de dados, verificando se as duas são compatíveis
			(se sim, retorna TRUE, se não, retorna FALSE) */

			$verificaSenha = password_verify($senha, $row['senha_user']);}

			else{ $verificaSenha = FALSE;}
		
		//fechando a conexão depois de armazenar os dados

		mysqli_close($connect);
		
		//numeros de linhas do resultado da query maior que 0 ou se houver algum registro do nome de usuário na tabela na tabela, $verificaSenha igual a TRUE se a senha digitada é compatível com a senha do banco de dados
		/* Se o nome e senha digitados pelo usuário são compatíveis com nome e senha de um usuário no banco de dados, ele loga no site */

		if ((mysqli_num_rows($resultado) > 0) && ($verificaSenha == TRUE)){

			/* Se o usuário não está ativo, envia um alerta pedindo a ele para confirmar sua conta */

			if($confirmado['FK_SIT_USUARIO_id_sit'] != 1){

				echo ("<SCRIPT LANGUAGE='JavaScript'>
            	window.alert('Você precisa confirmar sua conta antes de logar no site!');
            	</SCRIPT>");

			}

			/* Se o usuário está ativo, a sessão 'logado' é iniciada */

			elseif($confirmado['FK_SIT_USUARIO_id_sit'] == 1){

				$dados = mysqli_fetch_array($resultado);
				$_SESSION['logado']= true;
				$_SESSION['id_user']= $dados['id_user'];
				//comando que redireciona para página index.php
				header('Location: index.php');	}}
	
		else{

			$erroLoginSenha ="Seu login ou senha podem estar errados!";
		}
			
		endif;
	endif;	


?>

<section class="login">

<form class="caixa" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

	<h1> Login </h1>
	<input type="text" name="login" placeholder="Usuário"><br>
 	<input type="password" name='senha' placeholder="Senha">
 	<button class="button" type="submit" name="btn-entrar">Entrar</button>
 	<span class="erro"><?php echo $erroLoginSenha; ?></span>

 	<a href="cadastro.php">
    	<input type="button" name="cadastro" value="Criar conta">
 	</a>

	 <div id="g_id_onload"
         data-client_id="75991242224-4b2kpbl51f2aj8774krit95hj62h2mmj.apps.googleusercontent.com"
         data-login_uri="<script> document.write(loc); </script>"
         data-auto_prompt="false"
		 data-callback="handleCredentialResponse">
      </div>
      <div class="g_id_signin"
         data-type="icon"
         data-size="large"
         data-theme="outline"
         data-text="sign_in_with"
         data-shape="circle"
         data-logo_alignment="left"
		 >
	</div>

	  <script>
			function handleCredentialResponse(response) {

				// decodeJwtResponse() is a custom function defined by you
				// to decode the credential response.
				const responsePayload = jwt_decode(response.credential);
				var email = responsePayload.email;

				var loc = "http://localhost/root/index.php?key="+email;

				console.log(loc)
           		
				console.log("ID: " + responsePayload.sub);
				console.log('Full Name: ' + responsePayload.name);
				console.log('Given Name: ' + responsePayload.given_name);
				console.log('Family Name: ' + responsePayload.family_name);
				console.log("Image URL: " + responsePayload.picture);
				console.log("Email: " + responsePayload.email);

				


			}

		</script>

		<?php

		if(isset($_GET['key'])):

			$confirmaEmail = $_GET['key'];

			$confirma_user = mysqli_query($connect, "SELECT FK_SIT_USUARIO_id_sit FROM usuario WHERE email_user = $confirmaEmail");
			$confirmado = $confirma_user->fetch_assoc();

			$resultado = mysqli_query($connect,"SELECT id_user FROM usuario WHERE email_user = $confirmaEmail");

			if($confirmado['FK_SIT_USUARIO_id_sit'] == 1){

				$dados = mysqli_fetch_array($resultado);
				$_SESSION['logado']= true;
				$_SESSION['id_user']= $dados['id_user'];
				//comando que redireciona para página index.php
				header('Location: index.php');	


			}

			else{

				echo ("<SCRIPT LANGUAGE='JavaScript'>
            	window.alert('Você precisa confirmar sua conta antes de logar no site!');
            	</SCRIPT>");


			}

		endif;

	?>


	 <a href="recuperar_senha.php">
    	<input type="button" name="recuperaSenha" value="Recuperar Senha">
 	</a>

	 <script src="https://accounts.google.com/gsi/client" async defer></script>
	 <script src="https://unpkg.com/jwt-decode/build/jwt-decode.js"></script>
</form>


</body>