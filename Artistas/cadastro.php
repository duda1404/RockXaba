<!--
####################################################################################################################
########################################## CADASTRO ROCKXABA ARTISTAS ##############################################
####################################################################################################################
-->

<?php

include_once('sair.php');

// Incluir arquivo de configuração
require_once "config.php";

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    //Dados
    $id = $_SESSION['id'];
    $sql = "SELECT id_user from usuario where id_user = '$id'";
    $sql2 = "SELECT id_artista from artista where FK_USUARIO_id_user = $id";
    $sql3 = "SELECT email_user from usuario where id_user = $id";
    $stmt = $pdo->prepare($sql);
    $stmt2 = $pdo->prepare($sql2);
    $stmt->execute();
    $stmt2->execute();
    $sqlA = "SELECT fk_situacao_id_sit FROM artista WHERE fk_usuario_id_user = '$id'";
    $stmtA = $pdo->prepare($sqlA);
    $stmtA->execute();
    $row_verifica = $stmtA->fetch();

    /* ================ LISTA DE SITUAÇÕES ================ 

        1 - Ativo
        2 - Inativo
        3 - Aguardando Confirmação
        4 - Recadastro 

       ===================================================== */

    /* Impedindo que usuários já cadastrados como artistas, sejam aqueles 
    que estão aguardando a aprovação da página, ou aqueles que já tiveram 
    suas páginas aprovadas, acessem o cadastro novamente.               */

    if ($stmtA->rowCount() == 1) {

        /* Aguardando confirmação */
        if ($row_verifica['fk_situacao_id_sit'] == 3) {

            header('Location: muito_obrigado.php');
        }

        /* Se a pessoa já é uma Artista ativa no RockXaba */ 
        else if ($row_verifica['fk_situacao_id_sit'] == 1) {

            
            header('Location: dashboard.php');
            
        } else if ($row_verifica['fk_situacao_id_sit'] == 4) {

            /* Se a situação do usuário é de recadastro, a página recadastro será chamada, e será responsável
           não pela inserção dos dados no banco, mas pela alteração dos que já existem e não foram aprovados,
           pelos dados novamente inseridos no formulário */

            require('recadastro.php');
        }
    } else { 
      

        require('valida_cadastro.php');

    
    }

} else {

    header("Location: index.php");

}



$sql = "SELECT dsc_genero FROM genero";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$array = $stmt->fetchAll();
$contando = count($array);


?>

<!doctype html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- CSS do multi-seletor de gêneros-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<body class="cadastro-artista">
    <div class="conteudo">
        <h3 class="texto-artista"> Crie e Compartilhe com o RockXaba<h3>
                <form method="POST" id="formulario-cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="cadastro-artista-form" enctype="multipart/form-data">
                    <div class="form-p1">
                        <p> Insira seu nome de Artista ou Banda </p>
                        <input type="text" class="input-cadastro-artista" id="nome-artista" name="nome-artista" <?php if (!empty($nome_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['nome-artista'])) { ?> value='<?php echo $_POST['nome-artista'] ?>' <?php } ?> required>
                        <div class="erro">
                            <p class="erro"><?php echo $nome_erro; ?></p>
                        </div>
                        <p> Faça uma descrição (máx 500 caracteres) </p>
                        <input type="text" class="input-cadastro-artista" id="dsc-artista" name="dsc-artista" maxlength="500" minlength="20" <?php if (!empty($dsc_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['dsc-artista'])) { ?> value='<?php echo $_POST['dsc-artista'] ?>' <?php } ?> required>
                        <div class="erro">
                            <p class="erro"><?php echo $dsc_erro; ?></p>
                        </div>
                        <p> Conte em qual/quais gêneros você se encaixa musicalmente </p>
                        <select name="generos[]" id="generos" multiple>
                            <?php for ($i = 0; $i < $contando; $i++) { ?>
                                <option value="<?php echo $array[$i]['dsc_genero'] ?>"><?php echo $array[$i]['dsc_genero'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="erro">
                            <p class="erro"><?php echo $generos_erro; ?></p>
                        </div>
                        <p> Escolha uma imagem de perfil (sua logo) </p>
                        <input type="file" class="input-imagem" id="input-logo-artista" name="logo-name" required>
                        <div class="erro">
                            <p class="erro"><?php echo $logo_erro; ?></p>
                        </div>
                        <p> Escolha até 5 fotos para sua página </p>
                        <input id="files" name="fotos[]" type="file" accept=".jpg, .jpeg, .png" multiple required>
                        <div class="erro">
                            <p class="erro"><?php echo $row_fotos_erro; ?></p>
                        </div>
                    </div>
                    <div class="form-p2">
                        <p> Nome no Instagram (opcional) </p>
                        <input type="text" class="input-cadastro-artista" id="nome-insta-artista" name="nome-insta" <?php if (!empty($nome_insta_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['nome-insta'])) { ?> value='<?php echo $_POST['nome-insta'] ?>' <?php } ?>>
                        <div class="erro">
                            <p class="erro"><?php echo $nome_insta_erro; ?></p>
                        </div>
                        <img class="gif-tutorial" src="img/tutorial_1.gif" width="500px" height="300px">
                        <p> Assista o gif tutorial e cole aqui seu link do Spotify ou YouTube </p>
                        <input type="radio" id="spotify" name="link_musicas" onclick="chamaCampo()" value="Spotify">
                        <label for="spotify_link"> Usar embed do Spotify </label><br>
                        <input type="text" class="input-cadastro-artista" id="link-spotify" name="link-spotify" style="display: none;" <?php if (!empty($link_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['link-spotify'])) { ?> value='<?php echo $_POST['link-spotify'] ?>' <?php } ?>>
                        <input type="radio" id="youtube" name="link_musicas" onclick="chamaCampo()" value="YouTube">
                        <label for="youtube_link"> Usar embed YouTube</label><br>
                        <input type="text" class="input-cadastro-artista" id="link-youtube" name="link-youtube" style="display: none;" <?php if (!empty($link_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['link-youtube'])) { ?> value='<?php echo $_POST['link-youtube'] ?>' <?php } ?>>
                        <div class="erro">
                            <p class="erro"><?php echo $link_erro; ?></p>
                        </div>
                        <p> Dê cor para o seu perfil </p>
                        <label class="container">
                            <input type="radio" class="radio" id="radio-1" name="group" value="red" />
                            <label for="radio-1"> Vermelho </label>
                            <input type="radio" class="radio" id="radio-2" name="group" value="blue" />
                            <label for="radio-2"> Azul </label>
                            <input type="radio" class="radio" id="radio-3" name="group" value="green" />
                            <label for="radio-3"> Verde </label>
                            <input type="radio" class="radio" id="radio-4" name="group" value="yellow" />
                            <label for="radio-4"> Amarelo </label>
                        </label>
                        <div class="erro">
                            <p class="erro"><?php echo $cor_erro; ?></p>
                        </div>
                        <p> Contato (Email) </p>
                        <input type="email" class="input-cadastro-artista" id="contato-artista" name="contato-artista" <?php if (!empty($contato_erro)) { ?> style='border: 2px solid red;' <?php } ?> <?php if (isset($_POST['contato-artista'])) { ?> value='<?php echo $_POST['contato-artista'] ?>' <?php } ?> required>
                        <div class="erro">
                            <p class="erro"><?php echo $contato_erro; ?></p>
                        </div>
                        <button type="submit" id="enviar_btn" class="botao-evento"> Enviar </button>
                    </div>
                </form>

                <a href="?sair">Sair</a>
    </div>
    <!-- JavaScript do multi-seletor de gêneros-->
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <!-- Importa o arquivo script.js, que contém o JavaScript interno do site -->
    <script src="js/script.js"></script>

</body>

</head>