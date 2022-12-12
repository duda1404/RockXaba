<!--
####################################################################################################################
######################################### DASHBOARD ROCKXABA ARTISTAS ##############################################
####################################################################################################################
-->

<?php

session_start();
ob_clean();

include_once('sair.php');
// Incluir arquivo de configuração
require('config.php');

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

    //Dados
    $id = $_SESSION['id'];
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

    /* Impedindo que usuários não aprovados acessem o dashboard  */

    if ($stmtA->rowCount() == 1) {

        /* Aguardando confirmação */
        if ($row_verifica['fk_situacao_id_sit'] == 3) {

            header('Location: muito_obrigado.php');
        } else if ($row_verifica['fk_situacao_id_sit'] == 4) {


            header('Location: cadastro.php');
        }
    } else {

        header('Location: cadastro.php');
    }
} else {

    header("Location: index.php");
}

require('valida_edição.php');

/* ============================= IMPRESSÃO DE DADOS QUE JÁ ESTÃO NO BANCO NO FORMULÁRIO ============================= */

/* Pegando os dados da tabela de Artista */

$sql = "SELECT id_artista, nome_artista, link_play, dsc_artista, dat_add_artista, fk_usuario_id_user, 
cor_artista, nome_insta, contato FROM artista WHERE fk_usuario_id_user = $id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$array_artista = $stmt->fetch();
$nome_echo = $array_artista['nome_artista'];
$dsc_echo = $array_artista['dsc_artista'];
$link_echo = $array_artista['link_play'];
$cor_echo = $array_artista['cor_artista'];
$nome_insta_echo = $array_artista['nome_insta'];
$contato_echo = $array_artista['contato'];
$FK_id_artista = $array_artista['id_artista'];

$sql = "SELECT dsc_genero FROM genero";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$array = $stmt->fetchAll();
$contando = count($array);


?>
<html>

<head>
    <!-- CSS do multi-seletor de gêneros-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <link rel="stylesheet" type="text/css" href="style.css">

<body class="dashboard">
    <div class="editar-perfil">
        <h3 id="seu-nome"><?php echo $nome_echo; ?></h3>
        <form method="POST" id="formulario-cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="editar-perfil-form" enctype="multipart/form-data">
            <div class="form-p1" id="editar-form-p1">
                <p> Edite seu nome de Artista ou Banda </p>
                <input type="text" class="input-cadastro-artista" id="nome-artista" name="nome-artista" <?php if (!empty($nome_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $nome_echo; ?>' required>
                <div class="erro">
                    <p class="erro"><?php echo $nome_erro; ?></p>
                </div>
                <p> Edite sua descrição (máx 500 caracteres) </p>
                <input type="text" class="input-cadastro-artista" id="dsc-artista" name="dsc-artista" maxlength="500" minlength="20" <?php if (!empty($dsc_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $dsc_echo; ?>' required>
                <div class="erro">
                    <p class="erro"><?php echo $dsc_erro; ?></p>
                </div>
                <p> Edite seus gêneros </p>
                <select name="generos[]" id="generos" multiple>
                    <?php for ($i = 0; $i < $contando; $i++) { ?>
                        <option value="<?php echo $array[$i]['dsc_genero'] ?>"><?php echo $array[$i]['dsc_genero'] ?></option>
                    <?php } ?>
                </select>
                <div class="erro">
                    <p class="erro"><?php echo $generos_erro; ?></p>
                </div>
                <p> Edite sua imagem de perfil (sua logo) </p>
                <input type="file" class="input-imagem" id="input-logo-artista" name="logo-name" required>
                <div class="erro">
                    <p class="erro"><?php echo $logo_erro; ?></p>
                </div>
                <p> Edite as fotos da sua página (até 5 fotos) </p>
                <input id="files" name="fotos[]" type="file" accept=".jpg, .jpeg, .png" multiple required>
                <div class="erro">
                    <p class="erro"><?php echo $row_fotos_erro; ?></p>
                </div>
            </div>
            <div class="form-p2">
                <p> Edite seu nome no Instagram (opcional) </p>
                <input type="text" class="input-cadastro-artista" id="nome-insta-artista" name="nome-insta" <?php if (!empty($nome_insta_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $nome_insta_echo; ?>'>
                <div class="erro">
                    <p class="erro"><?php echo $nome_insta_erro; ?></p>
                </div>
                <p> Edite seu link do Spotify ou do YouTube </p>
                <input type="radio" id="spotify" name="link_musicas" onclick="chamaCampo()" value="Spotify">
                <label for="spotify_link"> Usar embed do Spotify </label><br>
                <input type="text" class="input-cadastro-artista" id="link-spotify" name="link-spotify" style="display: none;" <?php if (!empty($link_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $link_echo; ?>'>
                <input type="radio" id="youtube" name="link_musicas" onclick="chamaCampo()" value="YouTube">
                <label for="youtube_link"> Usar embed YouTube</label><br>
                <input type="text" class="input-cadastro-artista" id="link-youtube" name="link-youtube" style="display: none;" <?php if (!empty($link_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $link_echo; ?>'>
                <div class="erro">
                    <p class="erro"><?php echo $link_erro; ?></p>
                </div>
                <p> Edite a cor da sua página </p>
                <label class="container">
                    <input type="radio" class="radio" id="radio-1" name="group" value="red" />
                    <label for="radio-1"> Vermelho </label>
                    <input type="radio" class="radio" id="radio-2" name="group" value="blue" />
                    <label for="radio-2"> Azul </label>
                    <input type="radio" class="radio" id="radio-3" name="group" value="green" />
                    <label for="radio-3"> Verde </label>
                    <input type="radio" class="radio" id="radio-4" name="group" value="yellow" />
                    <label for="radio-4"> Amarelo </label>
                    <input type="radio" class="radio" id="radio-5" name="group" value="pink" />
                    <label for="radio-4"> Pink </label>
                </label>
                <div class="erro">
                    <p class="erro"><?php echo $cor_erro; ?></p>
                </div>
                <p> Edite seu contato (email) </p>
                <input type="email" class="input-cadastro-artista" id="contato-artista" name="contato-artista" <?php if (!empty($contato_erro)) { ?> style='border: 2px solid red;' <?php } ?> value='<?php echo $contato_echo; ?>' required>
                <div class="erro">
                    <p class="erro"><?php echo $contato_erro; ?></p>
                </div>
                <button type="submit" id="enviar_btn" class="botao-enviar cadastro"> Salvar </button>
            </div>
        </form>
        <a href="cadastrar_evento.php">
            <button type="button" id="cad-evento" class="botao-enviar cadastro"> Cadastrar Evento </button>
        </a>
        <a href="?sair">Sair</a>
    </div>
    <?php
    $sql = "SELECT id_evento, nome_evento, dsc_evento, dat_evento, fk_situacao_id_sit FROM evento WHERE fk_usuario_id_user = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $array_evento = $stmt->fetch();
    $sql = "SELECT COUNT(id_evento) FROM evento";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $array_count = $stmt->fetch();



    ?>
    <div class="meus-eventos">
        <h2 id="meus-eventos"> Meus Eventos</h2>
        <div class="caixa-eventos">
            <?php if ($array_count['count'] == 1) {
                $_SESSION['id_evento'] = $array_evento['id_evento']; ?>
                <div class="evento">
                    <h4 id="titulo-evento"><?php echo $array_evento['nome_evento']; ?></h4>
                    <h4 id="status" <?php if ($array_evento['fk_situacao_id_sit'] == 2) { ?> style="color: red" <?php } else { ?> style="color: green;" <?php } ?>> Status: <?php if ($array_evento['fk_situacao_id_sit'] == 2) { ?> Desativado <?php
                                                                                                                                                                                                                                            } else { ?> Ativado <?php } ?></h4>
                    <div class="texto-botao">
                        <p><?php echo $array_evento['dsc_evento']; ?></p>
                        <?php if ($array_evento['fk_situacao_id_sit'] == 1) { ?>
                            <button type="button" class="botao-ativa-desativa" onclick="desativaAtiva('desativa_evento.php')"> DESATIVAR </button>
                        <?php } ?>
                        <?php if ($array_evento['fk_situacao_id_sit'] == 2) { ?>
                            <button type="button" class="botao-ativa-desativa" id="botao-ativar" onclick="desativaAtiva('ativa_evento.php')"> ATIVAR </button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($array_count['count'] == 0 || @$array_count['count'] == NULL) {  ?>
                <p> Você não cadastrou nenhum Evento ainda! </p>
            <?php } ?>
        </div>
        </div>
</body>
<!-- JavaScript do multi-seletor de gêneros-->
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<!-- Importa o arquivo script.js, que contém o JavaScript interno do site -->
<script src="js/script.js"></script>
</head>