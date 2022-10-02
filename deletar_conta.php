<?php

    session_start();
    require 'config.php';

    $id = $_SESSION['id_user'];

    $DeletarConta = pg_query($connect, "UPDATE usuario SET fk_situacao_id_sit = 2 WHERE id_user=$id");
    pg_close();
    session_destroy();
    header('Location: index.php');

    

?>