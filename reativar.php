<?php

    session_start();
    require 'config.php';
    $nome = $_SESSION['nome_prev'];
    $senhaCriptografada = $_SESSION['senha_prev'];

    $update = "UPDATE usuario SET FK_SITUACAO_id_sit = 1  WHERE nome_user = '$nome' AND senha_user = '$senhaCriptografada'";
    $confirma_conta = pg_query($connect, $update);

    header('Location: index.php');
    //fechando a conexão depois de armazenar os dados

	
    session_destroy();

?>
