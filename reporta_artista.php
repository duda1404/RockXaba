<?php

    session_start();
    require 'config.php';
   
    $texto = $_GET['text'];
    $nome_user = $_SESSION['nome_userr'];
    $id_user = $_SESSION['id_userr'];
    $nome_artista = $_SESSION['nome_artista'];
    $id_artista = $_SESSION['id_artista'];
    $email_user = $_SESSION['email_userr'];

    $emailEnvia = $email_user;
	$apelidoEnvia = $nome_user;
    $emailRecebe = 'rockxaba027@gmail.com';
	$apelidoRecebe = 'RockXaba';

	$body = "<strong> O Artista ".$nome_artista.", de ID ".$id_artista.", foi reportado pelo usuário ".$nome_user."
    de ID ".$id_user." e email ".$email_user.", pelo seguinte motivo: ".$texto."</strong> ";

	$assunto = 'Reportando Artista';

    include 'emails.php';
   
    header('Location: artista_page.php?myid='.$id_artista);


	
   

?>