<!--
####################################################################################################################
########################################## MAIN ROCKXABA ARTISTAS ##################################################
####################################################################################################################
-->

<?php

// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de cadastro
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    session_destroy();
}

if (isset($_GET['acao'])) {

    $acao = $_GET['acao'];

    if ($acao == 'sair') {

        echo '<div class="alert alert-warning" role="alert">
    <strong> Você saiu do seu perfil!</strong> Esperamos que logue novamente
  </div>';
    }
}

// Incluir arquivo de configuração
require_once "config.php";

// Defina variáveis e inicialize com valores vazios
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifique se o nome de usuário está vazio
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, insira o nome de usuário.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Verifique se a senha está vazia
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, insira sua senha.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar credenciais
    if (empty($username_err) && empty($password_err)) {
        // Prepare uma declaração selecionada
        $sql = "SELECT id_user, nome_user, senha_user FROM usuario WHERE nome_user = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Definir parâmetros
            $param_username = trim($_POST["username"]);

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id_user"];
                        $username = $row["nome_user"];
                        $hashed_password = $row["senha_user"];

                        if (password_verify($password, $hashed_password)) {
                            // A senha está correta, então inicie uma nova sessão
                            session_start();

                            // Armazene dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            $sql = "SELECT fk_situacao_id_sit FROM artista WHERE fk_usuario_id_user = '$id'";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $row = $stmt->fetch();

                            /* ================ LISTA DE SITUAÇÕES ================ 

                                1 - Ativo
                                2 - Inativo
                                3 - Aguardando Confirmação
                                4 - Recadastro 

                               ===================================================== */

                            /* Se a pessoa já está cadastrada */
                            if ($stmt->rowCount() == 1) {

                                /* Aguardando confirmação */
                                if ($row['fk_situacao_id_sit'] == 3) {

                                    header('Location: muito_obrigado.php');
                                }
                                /* Recadastro autorizado */ 
                                else if ($row['fk_situacao_id_sit'] == 4) {

                                    header('Location: cadastro.php');
                                }

                                /* Se a pessoa já é uma Artista ativo no RockXaba */ 
                                else if ($row['fk_situacao_id_sit'] == 1) {

                                    header('Location: dashboard.php');
                                }

                                /* Quando a conta da pessoa foi inativada */
                                else if($row['fk_situacao_id_sit'] == 2){

                                    header('inativado.php');
                                }
                            } else {
                                
                               
                                header('Location: cadastro.php');
                                
                            }
                        } else {
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else {
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $login_err = "Nome de usuário ou senha inválidos.";
                }
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }

    // Fechar conexão
    unset($pdo);
}



?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body class="main">
    <div class="texto-main">
        <h3 class="texto-index"> Ainda não é Artista Parceiro do RockXaba?<h3>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formulario-cadastro">
                    <?php
                    if (!empty($login_err)) {
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                    ?>
                    <p id="texto-form"> Nome de usuário</p>
                    <input type="text" class="input-form <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    <p id="texto-form"> Senha </p>
                    <input type="password" name="password" class="input-form <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    <button type="submit" class="botao-entrar"> Entrar </button>
                </form>
    </div>

</body>

</html>