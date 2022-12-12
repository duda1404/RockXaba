<?php

include_once('sair.php');

// Incluir arquivo de configuração
require("config.php");

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
    $sql = "SELECT nome_artista FROM artista";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $array = $stmt->fetchAll();
    $contando = count($array);

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
        } else if ($row_verifica['fk_situacao_id_sit'] == 1) {

            include('valida_evento.php');
        } else if ($row_verifica['fk_situacao_id_sit'] == 4) {

            /* Se a situação do usuário é de recadastro, a página recadastro será chamada, e será responsável
           não pela inserção dos dados no banco, mas pela alteração dos que já existem e não foram aprovados,
           pelos dados novamente inseridos no formulário */

            require('recadastro.php');
        }
    } else {

        header('Location: cadastro.php');
    }
} else {

    header("Location: index.php");
}


?>

<!doctype html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- CSS do multi-seletor de gêneros-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<body class="cadastro-artista">
    <div class="conteudo">
        <h3 class="texto-artista"> Cadastrar Eventos </h3>
        <form method="POST" id="formulario-cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="cadastro-artista-form" enctype="multipart/form-data">
            <div class="form-p1">
                <p> Insira o nome do Evento </p>
                <input type="text" class="input-cadastro-artista" id="nome-artista" name="nome-artista" <?php if (!empty($nome_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['nome-artista'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $nome_erro; ?></p>
                </div>
                <p> Insira a data e hora do Evento </p>
                <input type="datetime-local" class="input-cadastro-artista" id="nome-artista" name="data-evento" <?php if (!empty($data_evento_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['data-evento'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $data_evento_erro; ?></p>
                </div>
                <p> Insira o local do Evento </p>
                <input type="text" class="input-cadastro-artista" id="nome-artista" name="local-evento" <?php if (!empty($local_evento_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['local-evento'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $local_evento_erro; ?></p>
                </div>
                <p> Insira o preço da entrada do Evento </p>
                <input type="text" class="input-cadastro-artista" id="nome-artista" name="preco-evento" <?php if (!empty($preco_evento_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['preco-evento'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $preco_evento_erro; ?></p>
                </div>
                <p> Insira a data e a hora de início da venda de ingressos </p>
                <input type="datetime-local" class="input-cadastro-artista" id="nome-artista" name="data-inicio-ingresso" <?php if (!empty($dat_inicio_ingre_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['data-inicio-ingresso'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $dat_inicio_ingre_erro; ?></p>
                </div>
                <p> Insira a data e a hora de fim da venda de ingressos </p>
                <input type="datetime-local" class="input-cadastro-artista" id="nome-artista" name="data-fim-ingresso" <?php if (!empty($dat_fim_ingre_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['data-fim-ingresso'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $dat_fim_ingre_erro; ?></p>
                </div>
                <p> Faça uma descrição (máx 500 caracteres) </p>
                <input type="text" class="input-cadastro-artista" id="dsc-artista" name="dsc-artista" maxlength="500" minlength="20" <?php if (!empty($dsc_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['dsc-artista'] ?>' <?php } ?> required>
                <div class="erro">
                    <p class="erro"><?php echo $dsc_erro; ?></p>
                </div>
                
            </div>
            <div class="form-p2">
            <p> Escolha uma imagem lateral para o Evento </p>
                <label for="input-logo-artista" class="minha-label">Enviar arquivo</label>
                <input type="file" class="input-imagem" id="input-logo-artista" name="logo-name" required>
                <div class="erro">
                    <p class="erro"><?php echo $logo_erro; ?></p>
                </div>
                <p> Escolha uma imagem de fundo do Evento </p>
                <label for="input-logo-evento" class="minha-label">Enviar arquivo</label>
                <input type="file" class="input-imagem" id="input-logo-evento" name="fundo-name" required>
                <div class="erro">
                    <p class="erro"><?php echo $fundo_erro; ?></p>
                </div>
                <p> Escolha até 5 fotos para a página do Evento </p>
                <label for="files" class="minha-label">Enviar arquivos</label>
                <input id="files" name="fotos[]" type="file" accept=".jpg, .jpeg, .png" multiple required>
                <div class="erro">
                    <p class="erro"><?php echo $row_fotos_erro; ?></p>
                </div>
                <p> Assista o gif tutorial e cole aqui seu link do Google Maps </p>
                <input type="text" class="input-cadastro-artista" id="link-spotify" name="link-google-maps" <?php if (!empty($link_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['link-google-maps'] ?>' <?php } ?>>
                <div class="erro">
                    <p class="erro"><?php echo $link_erro; ?></p>
                </div>
                <p> Informe os Artistas que participarão do Evento: </p>
                <p> Artistas do RockXaba: </p>
                <select name="generos[]" id="generos" multiple>
                    <?php for ($i = 0; $i < $contando; $i++) { ?>
                        <option value="<?php echo $array[$i]['nome_artista'] ?>"><?php echo $array[$i]['nome_artista'] ?></option>
                    <?php } ?>
                </select>
                <p> Outros Artistas (artista1, artista2...): </p>
                <input type="text" class="input-cadastro-artista" id="nome-artista" name="artistas-evento" <?php if (!empty($artistas_evento_erro)) { ?> style='border: 2px solid red;' value='<?php echo $_POST['artistas-evento'] ?>' <?php } ?>>
                <div class="erro">
                    <p class="erro"><?php echo $artistas_evento_erro; ?></p>
                </div>
                <p> Dê cor para a página do Evento </p>
                <label class="container">
                    <input type="radio" class="radio" id="radio-1" name="group" value="red" />
                    <label for="radio-1"> Vermelho </label>
                    <input type="radio" class="radio" id="radio-2" name="group" value="blue" />
                    <label for="radio-2"> Azul </label>
                    <input type="radio" class="radio" id="radio-3" name="group" value="green" />
                    <label for="radio-3"> Verde </label>
                    <input type="radio" class="radio" id="radio-4" name="group" value="yellow" />
                    <label for="radio-4"> Amarelo </label>
                    <input type="radio" class="radio" id="radio-5" name="group" value="#f82b9f" />
                    <label for="radio-5"> Rosa </label>
                </label>
                <div class="erro">
                    <p class="erro"><?php echo $cor_erro; ?></p>
                </div>
                <div class="botoes-evento">
                    <button type="submit" id="enviar_btn" class="botao-evento"> Enviar </button>
                    <a href="dashboard.php">
                        <button type="button" id="enviar_btn" class="botao-voltar"> Voltar </button>
                    </a>
                    <a href="?sair" class="sair">Sair</a>
                </div>
            </div>
        </form>

    </div>
    <!-- JavaScript do multi-seletor de gêneros-->
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <!-- Importa o arquivo script.js, que contém o JavaScript interno do site -->
    <script src="js/script.js"></script>

</body>

</head>