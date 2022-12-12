<?php

    session_start();
    require 'config.php';
    $id_evento = $_SESSION['id_evento'];

    $update = "UPDATE evento SET FK_SITUACAO_id_sit = 1 WHERE id_evento = $id_evento";
    $stmt = $pdo->prepare($update);
    $stmt->execute();
  
    unset($_SESSION['id_evento']);

    header('Location: dashboard.php');
    //fechando a conexão depois de armazenar os dados

	

?>