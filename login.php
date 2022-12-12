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

		$resultado = pg_query($connect, "SELECT id_user, nome_user, senha_user FROM usuario WHERE nome_user= '$login'");

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
			} 
			
			elseif ($confirmado['fk_situacao_id_sit'] == 2) {

				$dados = pg_fetch_array($resultado);
				$_SESSION['nome_prev'] = $dados['nome_user'];
				$_SESSION['senha_prev'] = $dados['senha_user'];

				echo ("<SCRIPT LANGUAGE='JavaScript'>
				reativarConta('reativar.php');
        		</SCRIPT>");

			}
		} else {

			$erroLoginSenha = "Seu login ou senha podem estar errados!";
		}

	endif;
endif;

/* ============================== CADASTRO ============================== */

/* Validação do formulário */

/* Inicialização de variáveis utilizadas na validação */

$erroEmail = "";
$erroNome = "";
$erroSenha = "";
$erroRepeteSenha = "";

if (isset($_POST['btnentrar'])) {

	/* VALIDA CAMPO EMAIL */

	/* Verifica se o campo de email está vazio assim que o botão de Enviar formulário (submit) é pressionado, se sim, preenche uma variável com uma mensagem pedindo seu preenchimento */
	if (empty($_POST['email'])) {

		$erroEmail = "Por favor, informe um email";
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
	} else {

		/* Recebe uma variável email que é preenchida com o que foi escrito no campo de email e chama a função limpaPost*/

		$email = limpaPost($_POST['email']);

		/* Verifica se o que foi digitado é um email válido ou não. Caso seja diferente de válido, coloca uma mensagem de erro dentro da variável $erroEmail */

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$erroEmail = "Email inválido!";
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		}
	}

	/* VALIDA CAMPO USUÁRIO */

	/* Verifica se o campo de usuário está vazio assim que o botão de Enviar formulário (submit) é pressionado, se sim, emite uma mensagem pedindo seu preenchimento */
	if (empty($_POST['nome'])) {

		$erroNome = "Por favor, preencha o nome de usuário";
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
	} else {

		/* Recebe uma variável nome que é preenchida com o que foi escrito no campo de usuário e chama a função limpaPost*/

		$nome = limpaPost($_POST['nome']);

		/* Verifica se o que foi digitado é um texto válido ou não */
		/* Preg_match - Verifica o que foi inserido na String (nome) e, caso alguma condição seja acionada (! - caso seja falsa), retorna true ou false)*/
		/* Aceita letras minúsculas, maísculas de A até Z, números de 0-9, underline e exige começar com letra*/

		if (!preg_match("/^[a-zA-Z][a-zA-Z\d_]*$/", $nome)) {

			$erroNome = "Apenas aceitamos nomes de usuário que possuam letras, números e underline!";
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		}
	}

	/* VALIDA CAMPO SENHA */

	if (empty($_POST['senha'])) {

		$erroSenha = "Por favor, preencha sua senha";
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
	} else {

		/* Recebe uma variável senha que é preenchida com o que foi escrito no campo de Senha e chama a função limpaPost*/

		$senha = limpaPost($_POST['senha']);

		/* Verifica se o que foi digitado é uma senha válida ou não */
		/* strlen - verifica o tamanho da variável (senha) digitada*/
		/* Caso a senha tenhos que 6 dígitos, emite uma mensagem de erro*/

		if (strlen($senha) < 6) {

			$erroSenha = "A senha precisa ter, no mínimo, 6 dígitos";
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		}

		/* VALIDA CAMPO REPETE SENHA */

		if (empty($_POST['repeteSenha'])) {

			$erroRepeteSenha = "Por favor, preencha novamente sua senha";
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		} else {

			/* Recebe uma variável repeteSenha que é preenchida com o que foi escrito no campo de repeteSenha e chama a função limpaPost*/

			$repeteSenha = limpaPost($_POST['repeteSenha']);

			/* Verifica se a senha digitada é igual à senha digitada no campo Senha, caso contrário, preenche a variável de erro com uma mensagem informando o problema*/

			if ($repeteSenha != $senha) {

				$erroRepeteSenha = "A senha está diferente da digitada anteriormente!";
				echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
			}
		}
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

	/*
  echo "Email:" . $_POST['email'];
  echo "<br>";
  echo "Nome:" . $_POST['nome'] ;
  echo "<br>";
  echo "Senha:" . $_POST['senha'] ;
  echo "<br>";
  echo "Repete Senha:" . $_POST['repeteSenha'] ; 
*/

	/* Inclui a conexão com o Banco de Dados*/

	$email =  $_POST['email'];
	$nome = $_POST['nome'];

	/* Transforma a senha digitada pelo usuário em uma senha criptografada (uma hash, utilizando do algoritmo PASSWORD_DEFAULT) dentro da variável $senha */

	$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

	/* Faz uma consulta sql para verificar se o email e/ou o nome digitado pelo usuário já foi cadastrado ou não */

	$verifica_sql = pg_query($connect, "SELECT * FROM usuario WHERE email_user = '$email' and nome_user = '$nome' or email_user = '$email' or nome_user = '$nome'");

	/* Verifica se o resultado da consulta foi mais de 0, significando que o email e/ou o usuário já foi cadastrado, e informando o usuário sem cadastra-lo no banco de dados */

	if (pg_num_rows($verifica_sql) > 0) {

		/* Verificam separadamente se o email ou o nome de usuário já existem no banco de dados */

		$verifica_email = pg_query($connect, "SELECT * FROM usuario WHERE email_user = '$email'");
		$verifica_nome = pg_query($connect, "SELECT * FROM usuario WHERE nome_user = '$nome'");

		/* Se o email já existe no banco de dados, informa ao usuário */

		if (pg_num_rows($verifica_email) > 0) {

			echo 'Email já cadastrado!<br>';
			$erroEmail = "aa";
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		}

		/* Se o nome de usuário já existe no banco de dados, informa ao usuário */

		if (pg_num_rows($verifica_nome) > 0) {

			$erroNome = "aa";
			echo 'Nome de usuário não disponível!';
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.location.href='login.php#register'
        </SCRIPT>");
		}

		if ($_POST['senha'] != $_POST['repeteSenha']) {

			echo 'A senhas estão diferentes!';
			$erroRepeteSenha = 'A senhas estão diferentes!';
		}
	} else {

		/* Se o usuário ainda não foi cadastrado e se não houve erros na validação do formulário, insere seus dados no banco e pede a confirmação
      da conta por email (envia um email pela biblioteca PHPMailer) */

		if (($erroEmail == "") && ($erroNome == "") && ($erroSenha == "") && ($erroRepeteSenha == "")) {

			/* Gera uma chave criptografada com o email e a data para a confirmação do cadastro via email, pelo usuário */

			$chave = password_hash($_POST['email'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

			/* Insere o cadastro do usuário no Banco de Dados */

			$tipo_user = 1;
			$sit_user = 3;
			$data_add = date('Y-m-d H:i:s');

			$sql = "INSERT INTO usuario(email_user, nome_user, senha_user, chave_confirm, FK_TIPO_USUARIO_codigo, FK_SITUACAO_id_sit, data_add_user) VALUES ('" . $email . "','" . $nome . "','" . $senha . "', '" . $chave . "', '" . $tipo_user . "', '" . $sit_user . "','" . $data_add . "')";
			$resultado = pg_query($connect, $sql);

			//fechando a conexão depois de armazenar os dados

			pg_close($connect);

			$emailEnvia = 'rockxaba027@gmail.com';
			$apelidoEnvia = 'RockXaba';
			$emailRecebe = $_POST['email'];
			$apelidoRecebe = $_POST['nome'];

			$body = "<strong>Este email foi utilizado para a realização do cadastro no site RockXaba, </strong> 
        utilizando as seguintes informações: <br>
        Nome: " . $_POST['nome'] . "<br>
        Email: " . $_POST['email'] . "<br>
        Para confirmar seu cadastro, clique no link abaixo: <br>
        <a href='http://localhost/root/confirmar_email.php?chave=$chave'> Clique aqui </a>";

			$assunto = 'Confirmando cadastro';


			/* Inclui a página emails que enviará, por meio da biblioteca PHPMailer, um email para confirmação do cadastro */

			include 'emails.php';

			$_SESSION['confirma_email'] = $email;
			$_SESSION['confirma_nome'] = $nome;
			$_SESSION['confirma_chave'] = $chave;

			/* Redireciona à página de Login se o cadastro é concluído sem erros e mostra uma mensagem informando que precisa confirmá-lo */

			/*
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Cadastro concluído. Acesse sua caixa de email para confirmá-lo!');
        window.location.href='index.php'
        </SCRIPT>");
		*/
		}
	}
}



?>


<body id="pagina-login">

	<div class="card-login-cadastro">
		<div class="head">
			<div></div>
			<a id="login" class="selected" href="#login">Login</a>
			<a id="register" href="#register"> Cadastro </a>
			<div></div>
		</div>
		<div class="tabs">
			<form class="login-cadastro" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="inputs">
					<div class="input">
						<input placeholder="Nome de usuário" name="login" type="text">

					</div>
					<div class="input">
						<input placeholder="Senha" name="senha" type="password">

					</div>
				</div>
				<button class="botao-logar-cadastrar" type="submit" name="btn-entrar">Login</button>
			</form>
			<form class="login-cadastro" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="inputs">
					<div class="input">
						<input placeholder="Email" type="email" name="email" <?php if (!empty($erroEmail)) {
																					echo "class='invalido'";
																				} ?> <?php if (isset($_POST['email'])) {
																							echo "value='" . $_POST['email'] . "'";
																						} ?> placeholder="Email" required>

					</div>
					<div class="input">
						<input placeholder="Nome de usuário" type="text" name="nome" <?php if (!empty($erroNome)) {
																							echo "class='invalido'";
																						} ?> <?php if (isset($_POST['nome'])) {
																									echo "value='" . $_POST['nome'] . "'";
																								} ?> placeholder="Usuário" required>


					</div>
					<div class="input">
						<input placeholder="Senha" type="password" name="senha" <?php if (!empty($erroSenha)) {
																					echo "class='invalido'";
																				} ?> <?php if (isset($_POST['senha'])) {
																							echo "value='" . $_POST['senha'] . "'";
																						} ?> placeholder="Senha" required>



					</div>
					<div class="input">
						<input placeholder="Repita a senha" type="password" name="repeteSenha" <?php if (!empty($erroRepeteSenha)) {
																									echo "class='invalido'";
																								} ?> <?php if (isset($_POST['repeteSenha'])) {
																											echo "value='" . $_POST['repeteSenha'] . "'";
																										} ?> placeholder="Repita a senha" required>

					</div>
				</div>
				<button class="botao-logar-cadastrar" id="botao-cadastro" type="submit" name="btnentrar"> Cadastrar </button>
			</form>
		</div>
	</div>
	</div>

	<script>

		$(window).on("hashchange", function() {
			if (location.hash.slice(1) == "register") {
				$(".card-login-cadastro").addClass("extend");
				$("#login").removeClass("selected");
				$("#register").addClass("selected");
			} else {
				$(".card-login-cadastro").removeClass("extend");
				$("#login").addClass("selected");
				$("#register").removeClass("selected");
			}
		});
		$(window).trigger("hashchange");

	</script>

</body>
</body>