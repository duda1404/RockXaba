<?php

    session_start();
    require 'config.php';
   
    $texto = $_GET['text'];
    $nome_user = $_SESSION['nome_usuario'];
    $id_user = $_SESSION['id_usuario'];
    $nome_evento = $_SESSION['nome_evento'];
    $id_evento = $_SESSION['id_evento'];
    $email_user = $_SESSION['email_usuario'];

    $emailEnvia = $email_user;
	$apelidoEnvia = $nome_user;
    $emailRecebe = 'rockxaba027@gmail.com';
	$apelidoRecebe = 'RockXaba';

	$body = "<strong> O Evento ".$nome_evento.", de ID ".$id_evento.", foi reportado pelo usuário ".$nome_user."
    de ID ".$id_user." e email ".$email_user.", pelo seguinte motivo: ".$texto."</strong> ";

	$assunto = 'Reportando Evento';

    include 'emails.php';
   
    unset($_SESSION['id_evento']);
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome_usuario']);
    unset($_SESSION['nome_evento']);
    unset($_SESSION['email_usuario']);

    header('Location: evento_page.php?myid='.$id_evento);
    //fechando a conexão depois de armazenar os dados

	
   

?>