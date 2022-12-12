<?php

/*
####################################################################################################################
############################### PÁGINA DE VALIDAÇÃO DO CADASTRO DE BANDAS/ARTISTAS #################################
####################################################################################################################

*/


// Defina variáveis e inicialize com valores vazios
$nome_artista = $dsc_artista  = $logo_name = $row_fotos[] = $nome_insta = $link_spotify = $cor_artista = $contato = $generos[] = "";
$nome_erro = $dsc_erro  = $logo_erro = $row_fotos_erro = $nome_insta_erro = $link_erro = $cor_erro = $contato_erro = $generos_erro = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    /* ================================ VERIFICANDO SE OS CAMPOS ESTÃO VAZIOS ================================ */

    //O POST USA O ATRIBUTO NAME NOS CAMPOS DE INPUT PARA IDENTIFICÁ-LOS

    // Verifique se o nome de artista está vazio
    if (empty(trim($_POST["nome-artista"]))) {

        $nome_erro = "Por favor, insira seu nome de Artista/Banda.";
    } else {
        $nome_artista = trim($_POST["nome-artista"]);
    }

    // Verifique se a descrição está vazia
    if (empty(trim($_POST["dsc-artista"]))) {

        $dsc_erro = "Por favor, insira uma descrição para sua página!";
    } else {
        $dsc_artista = trim($_POST["dsc-artista"]);
    }

    //Coloca o nome-insta dentro de uma variável e o filtra
    //Como o campo nome-insta é de preenchimento opcional, não há necessidade de verificar se está vazio ou não
    if (!empty(trim($_POST["nome-insta"]))) {

        $nome_insta = trim($_POST["nome-insta"]);
    }

    // Verifique se o campo contato-artista está vazio
    if (empty(trim($_POST["contato-artista"]))) {

        $contato_erro = "Por favor, insira sua forma de contato.";
    } else {

        if (filter_var($_POST["contato-artista"], FILTER_VALIDATE_EMAIL)) {

            $contato = trim($_POST["contato-artista"]);
        } else {

            $contato_erro = "Email inválido!";
        }
    }

    //Verifica se alguma opção do seletor de cores foi escolhida
    if (!isset(($_POST['group']))) {

        $cor_erro = "Por favor, escolha uma cor para sua página";
    } else {

        $cor_artista = $_POST['group'];
    }

    if (!isset($_POST['link_musicas'])) {

        $link_erro = "Por favor, insira escolha um embed para suas músicas no Spotify ou Youtube";
    } else {

        if ($_POST['link_musicas'] == 'Spotify') {

            if (empty(trim($_POST['link-spotify']))) {


                $link_erro = "Por favor, insira um link embed para suas músicas no Spotify";
            } else {

                $link_spotify = trim($_POST["link-spotify"]);
            }
        } else if ($_POST['link_musicas'] == 'YouTube') {

            if (empty(trim($_POST['link-youtube']))) {

                $link_erro = "Por favor, insira um link embed para suas músicas no YouTube";
            } else {

                $link_spotify = trim($_POST["link-youtube"]);
            }
        }
    }


    //Verifica se algum gênero musical foi selecionado

    if (isset($_POST["generos"])) {

        $tamanho_generos = count($_POST['generos']);


        if ($tamanho_generos > 11 && $tamanho_generos < 0) {

            $generos_erro = "Você precisa selecionar, no mínimo, um gênero musical, e no máximo, 10 gêneros!";
        }
    } else if (@$_POST["generos"] == NULL) {

        $generos_erro = "Selecione pelo menos um gênero musical!";
    }

    //Verifica se o campo da logo do Artista/Banda está vazio
    if (!isset($_FILES['logo-name'])) {

        $logo_erro = "Por favor, insira sua logo";
    } else {

        if ($_FILES["logo-name"] != NULL && count($_FILES["logo-name"]) > 0) {

            $logo_name = $_FILES['logo-name']['name'];
        } else {

            $logo_erro = "Por favor, insira sua logo!";
        }
    }

    // Count total files

    if (isset($_FILES['fotos'])) {

        $myFile = $_FILES['fotos'];

        if ($myFile != NULL && count($myFile["name"]) > 1) {

            $fileCount = count($myFile["name"]);

            if ($fileCount > 5) {

                $row_fotos_erro = "Selecione, no máximo, 5 fotos!";
            } else {

                $row_fotos = $myFile;
            }
        } else {

            $row_fotos_erro = 'Selecione, pelo menos, duas fotos!';
        }

        //Validando o campo do nome no Instagram

        if (isset($_POST['nome-insta'])) {

            $nome_prev_insta = $_POST['nome-insta'];
            $requisitos = "/@(?:(?:[\w][\.]{0,1})*[\w]){1,29}/";

            if (!empty($nome_prev_insta) && preg_match($requisitos, $nome_prev_insta)) {

                $nome_insta_erro = "Esse nome de Instagram é inválido!";
            } else {

                $nome_insta = $_POST['nome-insta'];
            }
        }
    }

    /* ================================= ATUALIZAÇÃO DE DADOS ================================= */

    /* Verifica se é o primeiro cadastro do usuário */

    // Validar credenciais (se não ocorreu nenhum erro, portanto, todos os campos estão vazios)
    if (
        empty($nome_erro) && empty($dsc_erro) && empty($logo_erro) && empty($row_fotos_erro) &&
        empty($nome_insta_erro) && empty($link_erro) && empty($cor_erro) && empty($contato_erro) && empty($generos_erro)

    ) {
        //Verificando se não existe nenhum nome de Artista igual no banco de dados, que não seja do cadastro antes feito
        //pelo usuário que está se cadastrando agora
        // Prepare uma declaração selecionada


        $sql = "SELECT id_artista, nome_artista, dsc_artista FROM artista WHERE nome_artista ILIKE :nome_artista AND fk_usuario_id_user != $id";

        if ($stmt = $pdo->prepare($sql)) {

            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":nome_artista", $param_nome_artista, PDO::PARAM_STR);

            // Definir parâmetros
            $param_nome_artista = $nome_artista;

            // Tente executar a declaração preparada
            if ($stmt->execute()) {

                if ($stmt->rowCount() == 0) {

                    /* MODELO
            UPDATE accounts SET contact_first_name = first_name, contact_last_name = last_name
            FROM employees WHERE employees.id = accounts.sales_person; */

                    //determina o fuso horário correto para o uso nas funções de datas do PHP
                    date_default_timezone_set('America/Sao_Paulo');

                    $dat_add_artista = date('Y-m-d H:i:s');

                    $data = [
                        'nome_artista' => $nome_artista,
                        'dsc_artista' => $dsc_artista,
                        'link_play' => $link_spotify,
                        'dat_add_artista' => $dat_add_artista,
                        'FK_USUARIO_id_user' => $id,
                        'cor_artista' => $cor_artista


                    ];

                    $sql = "UPDATE artista SET nome_artista = :nome_artista, dsc_artista = :dsc_artista, link_play = :link_play, FK_USUARIO_id_user = :FK_USUARIO_id_user, 
            dat_add_artista = :dat_add_artista, cor_artista = :cor_artista WHERE fk_usuario_id_user = $id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($data);

                    $sql = "SELECT id_artista FROM artista WHERE FK_USUARIO_id_user = $id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $FK_id_artista = $row['id_artista'];


                    $fotos_sql = "DELETE FROM foto_artista WHERE FK_ARTISTA_id_artista = $FK_id_artista";
                    $stmt_fotos = $pdo->prepare($fotos_sql);
                    $stmt_fotos->execute();
                    $row_sql_fotos = $stmt_fotos->fetch();

                    $generos_sql = "DELETE FROM artista_genero WHERE FK_ARTISTA_id_artista = $FK_id_artista";
                    $stmt_generos = $pdo->prepare($generos_sql);
                    $stmt_generos->execute();
                    $row_sql_generos = $stmt_generos->fetch();

                    /* consulta para os gêneros */

                    foreach ($_POST['generos'] as $subject) {

                        $sql = "SELECT id_gen FROM genero WHERE dsc_genero = '$subject'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $FK_id_gen = $row['id_gen'];
                        $sql = "INSERT INTO artista_genero(FK_GENERO_id_gen, FK_ARTISTA_id_artista) VALUES ($FK_id_gen, $FK_id_artista)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }

                    /* inserindo a logo na pasta de uploads */

                    $photo_name = $_FILES["logo-name"]["name"];
                    $photo_tmp_name = $_FILES["logo-name"]["tmp_name"];
                    $photo_size = $_FILES["logo-name"]["size"];
                    $photo_new_name_logo = rand() . $photo_name;
                    move_uploaded_file($photo_tmp_name, "../uploads/" . $photo_new_name_logo);

                    /* consulta para a logo */

                    $sql = "INSERT INTO foto_artista(photo_artista, fk_artista_id_artista, logo_foto, fk_usuario_id_user) VALUES ('$photo_new_name_logo', $FK_id_artista, 'logo', $id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    /* consulta para as fotos */

                    $fileCount = count($row_fotos["name"]);

                    /* inserindo as fotos na pasta de uploads */

                    for ($i = 0; $i < $fileCount; $i++) {

                        $photo_name = $_FILES["fotos"]["name"][$i];
                        $photo_tmp_name = $_FILES["fotos"]["tmp_name"][$i];
                        $photo_size = $_FILES["fotos"]["size"][$i];
                        $photo_new_name = rand() . $photo_name;
                        move_uploaded_file($photo_tmp_name, "../uploads/" . $photo_new_name);

                        $row_fotos_nome[$i] = $photo_new_name;

                        $sql = "INSERT INTO foto_artista(photo_artista, fk_artista_id_artista, logo_foto, fk_usuario_id_user) VALUES ('$photo_new_name', $FK_id_artista, 'foto', $id)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }

                    /* consulta para o nome de instagram */

                    $sql = "UPDATE artista set nome_insta = '$nome_insta' where id_artista = $FK_id_artista";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    /* consulta para o contato (email) */

                    $sql = "UPDATE artista set contato = '$contato' where id_artista = $FK_id_artista";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    echo 'Perfil atualizado!';
                } else {

                    echo 'Esse nome de artista/banda já é usado por outro usuário!';
                }
            }
        }
    }

    // Fechar declaração
    unset($stmt);
}
