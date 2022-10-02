<?php

/* Inclui conexão com o Banco de Dados */

session_start();
require 'config.php';

/* Filtro que pega a variável chave da URL e a sanitiza*/

$chave = filter_input(INPUT_GET, "chave", FILTER_SANITIZE_STRING);

if (!empty($chave)) {

    /* Faz uma consulta sql para encontrar o id_user do usuário cuja chave seja igual à chave presente na URL, e transforma esse
    id em um item do $array. Se existe algum id_user que preenche esses requisitos, muda a situação do usuário para 'Ativo'
    no Banco de Dados, e coloca sua chave como NULL (nula) para que não possa utilizá-la mais de uma vez, confirmando sua conta novamente */

    $verifica_chave = pg_query($connect, "SELECT id_user FROM usuario WHERE chave_confirm = '$chave' LIMIT 1");
    $array = pg_fetch_assoc($verifica_chave);

    if (pg_num_rows($verifica_chave) > 0) {

        /* Update da situação do usuário de "Aguardando Confirmação" para "Ativo" */

        $update = "UPDATE usuario SET FK_SITUACAO_id_sit = 1  WHERE id_user = '" . $array['id_user'] . "'";
        $confirma_conta = pg_query($connect, $update);

        $deleta_chave =  "UPDATE usuario SET chave_confirm = NULL WHERE id_user = '" . $array['id_user'] . "'";
        $deletando = pg_query($connect, $deleta_chave);

        //fechando a conexão depois de atualizar os dados

        pg_close($connect);

        if ($confirma_conta) {

            session_destroy();

            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Conta confirmada! Faça o login para entrar em seu perfil!');
            window.location.href='login.php';
            </SCRIPT>");
        } else {

            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Erro de confirmação!');
            </SCRIPT>");
        }
    } else {

        //Quando a chave na URL não corresponde à nenhuma chave de usuário

        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Erro! Endereço Inválido! Reenviar email?');
        </SCRIPT>");

        echo '<form action="" method="POST">
                    <button type="submit" name="reenvia"> Reenviar Email </button>
                    </form>';

        if (isset($_POST['reenvia'])) {

            if(isset($_SESSION['confirma_email'])){

                $emailEnvia = 'rockxaba027@gmail.com';
                $apelidoEnvia = 'RockXaba';
                $emailRecebe = $_SESSION['confirma_email'];
                $apelidoRecebe = $_SESSION['confirma_nome'];
                $chaveReenvia = $_SESSION['confirma_chave'];

                $body = "<strong>Este email foi reenviado para a realização da confirmação do cadastro no site RockXaba, </strong> 
                utilizando as seguintes informações: <br>
                Nome: " . $apelidoRecebe . "<br>
                Email: " . $emailRecebe . "<br>
                Para confirmar seu cadastro, clique no link abaixo: <br>
                <a href='http://localhost/root/confirmar_email.php?chave=$chaveReenvia'> Clique aqui </a>";

                $assunto = 'Reenvio para confirmar cadastro';

                /* Inclui a página emails que enviará, por meio da biblioteca PHPMailer, um email para confirmação do cadastro */

                include 'emails.php';

                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Email reenviado!');
                window.location.href='cadastro.php';
                </SCRIPT>");
            }{
                echo 'Endereço Inválido! Verifique se sua conta já foi confirmada fazendo o login, ou tente se cadastrar no RockXaba!';
            }
          
        }
    }
} else {

    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Houve um erro! Chave vazia!');
        window.location('index.php');
        </SCRIPT>");
}
