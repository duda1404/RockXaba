<?php

/*
####################################################################################################################
############################### PÁGINA DE VALIDAÇÃO DO CADASTRO DE EVENTOS #########################################
####################################################################################################################

*/

session_start();
ob_clean();

/* ELEMENTOS DO EVENTO
nome do evento - nome_evento (varchar(200))
data do evento - dat_evento
descrição do evento - dsc_evento
local do evento - local_evento
preço do evento - preço_evento (varchar)
data limite do ingresso - dat_limite_ingresso
data de início do ingresso - dat_inicio_ingresso
data de adição do evento - dat_add_evento
google_maps
artistas
FK_USUARIO_id_user
FK_SITUACAO_id_sit 
front_page
*/

/* FOTO_EVENTO

id_photo
photo_evento 
FK_EVENTO_id_evento

*/

// Defina variáveis e inicialize com valores vazios
$nome_artista = $dsc_artista  = $logo_name = $row_fotos[] = $cor_artista = $data_evento = $dat_inicio_ingre = $dat_fim_ingre = $fundo_name = $link_spotify = $preco_evento = $local_evento = $artistas_evento = $fundo_erro ="";
$nome_erro = $dsc_erro  = $logo_erro = $row_fotos_erro = $cor_erro  = $data_evento_erro = $dat_inicio_ingre_erro = $dat_fim_ingre_erro = $link_erro = $preco_evento_erro = $fundo_evento = $local_evento_erro = $artistas_evento_erro = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    /* ================================ VERIFICANDO SE OS CAMPOS ESTÃO VAZIOS ================================ */

    //O POST USA O ATRIBUTO NAME NOS CAMPOS DE INPUT PARA IDENTIFICÁ-LOS

    // Verifique se o nome de artista está vazio
    if (empty(trim($_POST["nome-artista"]))) {

        $nome_erro = "Por favor, insira o nome do Evento.";
    } else {

        $nome_artista = trim($_POST["nome-artista"]);
    }


    // Verifique se a descrição está vazia
    if (empty(trim($_POST["dsc-artista"]))) {

        $dsc_erro = "Por favor, insira uma descrição para o Evento!";
    } else {
        $dsc_artista = trim($_POST["dsc-artista"]);
    }

    //Coloca o nome-insta dentro de uma variável e o filtra
    //Como o campo nome-insta é de preenchimento opcional, não há necessidade de verificar se está vazio ou não
    if (!empty(trim($_POST["data-evento"]))) {

        $data_evento = trim($_POST["data-evento"]);
    }
    else{
         $data_evento_erro = "Por favor, insira a data do Evento";
    }

    if (!empty(trim($_POST["data-inicio-ingresso"]))) {

        $dat_inicio_ingre = trim($_POST["data-inicio-ingresso"]);
    }
    else{
         
        $dat_inicio_ingre_erro = "Por favor, a data de início da venda de ingressos!";
    }

    if (!empty(trim($_POST["data-fim-ingresso"]))) {

        $dat_fim_ingre = trim($_POST["data-fim-ingresso"]);
    }
    else{
         
        $dat_fim_ingre_erro = "Por favor, a data de fim da venda de ingressos!";
    }


    // Verifique se o campo contato-artista está vazio
    if (empty(trim($_POST["local-evento"]))) {

        $local_evento_erro = "Por favor, insira o local do Evento!";

    } else {

        $local_evento = trim($_POST["local-evento"]);
       
    }

    if (empty(trim($_POST["preco-evento"]))) {

        $preco_evento_erro = "Por favor, insira o preço do ingresso do Evento!";
        
    } else {

        $preco_evento = trim($_POST["preco-evento"]);
       
    }

    //Verifica se alguma opção do seletor de cores foi escolhida
    if (!isset(($_POST['group']))) {

        $cor_erro = "Por favor, escolha uma cor para sua página";
    } else {

        $cor_artista = $_POST['group'];
    }

    if (!isset(($_POST['link-google-maps']))) {

        $link_erro = "Por favor, escolha insira o link embed do Google Maps";

    } else {

        $link_spotify = $_POST['link-google-maps'];
    }


    //Verifica se o campo da logo do Artista/Banda está vazio
    if (!isset($_FILES['logo-name'])) {

        $logo_erro = "Por favor, insira uma foto lateral para o Evento!";
    } else {

        if ($_FILES["logo-name"] != NULL && count($_FILES["logo-name"]) > 0) {

            $logo_name = $_FILES['logo-name']['name'];
        } else {

            $logo_erro = "Por favor, insira uma foto lateral para o Evento!";
        }
    }

     //Verifica se o campo da logo do Artista/Banda está vazio
     if (!isset($_FILES['fundo-name'])) {

        $fundo_erro = "Por favor, insira uma foto de fundo para o Evento!";
    } else {

        if ($_FILES["fundo-name"] != NULL && count($_FILES["fundo-name"]) > 0) {

            $fundo_name = $_FILES['fundo-name']['name'];
        } else {

            $fundo_erro = "Por favor, insira uma foto de fundo para o Evento!";
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
    }

    if((isset($_POST['generos']) && $_POST['generos'] != NULL || !empty($_POST['artistas-evento'])) ||
    (isset($_POST['generos']) && $_POST['generos'] != NULL && !empty($_POST['artistas-evento']))){

    if (isset($_POST["generos"]) && @$_POST['generos'] != NULL && !empty($_POST['artistas-evento'])) {

        $artistas_evento = $_POST['artistas-evento'];
        $artistas_evento = $artistas_evento.', '.implode(", ", $_POST['generos']);

    } 
    else if(isset($_POST["generos"]) && @$_POST['generos'] != NULL && empty($_POST['artistas-evento'])){

        $artistas_evento = implode(", ", $_POST['generos']);

    }
    else if(!isset($_POST["generos"]) || @$_POST['generos'] != NULL && !empty($_POST['artistas-evento'])){

        $artistas_evento = $_POST['artistas-evento'];
    }

}
else{

    $artistas_evento_erro = "Por favor, insira os Artistas participantes do Evento (cadastrados no RockXaba ou não)!";
}


    /* Verifica se é o primeiro cadastro do usuário */

    /* ================================ INSERINDO OS DADOS NO BANCO ================================ */

    // Validar credenciais (se não ocorreu nenhum erro, portanto, todos os campos estão vazios)
    if (
        empty($nome_erro) && empty($dsc_erro) && empty($logo_erro) && empty($row_fotos_erro) &&
        empty($dat_fim_ingre_erro) &&   empty($dat_inicio_ingre_erro) && empty($link_erro) && empty($cor_erro) 
        && empty($local_evento_erro) && empty($artistas_evento_erro) && empty($preco_evento_erro) && empty($data_evento_erro) && empty($fundo_erro)
    ) {
        //Verificando se não existe nenhum nome de Artista igual no banco de dados
        // Prepare uma declaração selecionada
        $sql = "SELECT nome_evento, dsc_evento, local_evento, artistas, dat_evento FROM evento WHERE nome_evento ILIKE :nome_evento";

        if ($stmt = $pdo->prepare($sql)) {

            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":nome_evento", $param_nome_artista, PDO::PARAM_STR);

            // Definir parâmetros
            $param_nome_artista = $nome_artista;

            // Tente executar a declaração preparada
            if ($stmt->execute()) {

                if ($stmt->rowCount() == 0) {

                    //determina o fuso horário correto para o uso nas funções de datas do PHP
                    date_default_timezone_set('America/Sao_Paulo');

                    $dat_add_artista = date('Y-m-d H:i:s');

                    $data = [
                        'nome_evento' => $nome_artista,
                        'dsc_evento' => $dsc_artista,
                        'google_maps' => $link_spotify,
                        'dat_add_evento' => $dat_add_artista,
                        'FK_USUARIO_id_user' => $id,
                        'FK_SITUACAO_id_sit' => 1,
                        'cor_evento' => $cor_artista,
                        'local_evento' => $local_evento,
                        'dat_limite_ingresso' => $dat_fim_ingre,
                        'dat_inicio_ingresso' => $dat_inicio_ingre,
                        'artistas' => $artistas_evento,
                        'dat_evento' => $data_evento,
                        'preco_evento' => $preco_evento
                        

                    ];

                    $sql = "INSERT INTO evento(nome_evento, dsc_evento, google_maps, FK_USUARIO_id_user, dat_add_evento, FK_SITUACAO_id_sit, cor_evento, local_evento, dat_limite_ingresso, dat_inicio_ingresso, artistas, dat_evento, preco_evento) VALUES (:nome_evento, :dsc_evento, :google_maps, :FK_USUARIO_id_user, :dat_add_evento, :FK_SITUACAO_id_sit, :cor_evento, :local_evento, :dat_limite_ingresso, :dat_inicio_ingresso, :artistas, :dat_evento, :preco_evento)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($data);

                    $sql = "SELECT id_evento FROM evento WHERE nome_evento = '$nome_artista'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $FK_id_evento = $row['id_evento'];

                    /* inserindo a logo na pasta de uploads */

                    $photo_name = $_FILES["logo-name"]["name"];
                    $photo_tmp_name = $_FILES["logo-name"]["tmp_name"];
                    $photo_size = $_FILES["logo-name"]["size"];
                    $photo_new_name_logo = rand() . $photo_name;
                    move_uploaded_file($photo_tmp_name, "../uploads/" . $photo_new_name_logo);

                    /* consulta para a logo */

                    $sql = "INSERT INTO foto_evento(photo_evento, fk_evento_id_evento, front_page) VALUES ('$photo_new_name_logo', $FK_id_evento, 'front')";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    /* inserindo a logo na pasta de uploads */

                    $photo_name = $_FILES["fundo-name"]["name"];
                    $photo_tmp_name = $_FILES["fundo-name"]["tmp_name"];
                    $photo_size = $_FILES["fundo-name"]["size"];
                    $photo_new_name_logo = rand() . $photo_name;
                    move_uploaded_file($photo_tmp_name, "../uploads/" . $photo_new_name_logo);

                    /* consulta para a logo */

                    $sql = "INSERT INTO foto_evento(photo_evento, fk_evento_id_evento, front_page) VALUES ('$photo_new_name_logo', $FK_id_evento, 'fundo')";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    /* consulta para as fotos */

                    $fileCount = count($row_fotos["name"]);
                    echo $fileCount;

                    /* inserindo as fotos na pasta de uploads */

                    for ($i = 0; $i < $fileCount; $i++) {

                        $photo_name = $_FILES["fotos"]["name"][$i];
                        $photo_tmp_name = $_FILES["fotos"]["tmp_name"][$i];
                        $photo_size = $_FILES["fotos"]["size"][$i];
                        $photo_new_name = rand() . $photo_name;
                        move_uploaded_file($photo_tmp_name, "../uploads/" . $photo_new_name);

                        $sql = "INSERT INTO foto_evento(photo_evento, fk_evento_id_evento, front_page) VALUES ('$photo_new_name', $FK_id_evento, 'page')";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }

                 
                } else {

                    $row = $stmt->fetch();

                    echo 'Esse nome de Evento já existe! Ele está registrado como um Evento que ocorrerá em '.$row['local_evento'].', com a participação
                    dos artistas '.$row['artistas'].' na seguinte data e hora '.$row['dat_evento'];
                }
            }
        }
    }

    // Fechar declaração
    unset($stmt);

    // Fechar conexão
    unset($pdo);
}



