<?php

//Guarda todas as sequências de saída em memória (cache)
ob_start();

//determina o fuso horário correto para o uso nas funções de datas do PHP
date_default_timezone_set('America/Sao_Paulo');

//iniciar a sessão
session_start();

header('Content-Type: text/html; charset=UTF-8');

//Inclui, uma vez, a página sair.php, que destrói a sessão quando o usuário clica no item do menu 'Sair', estabelecendo o método ?sair e inclui  conexão com o Banco de Dados
include_once('sair.php');
require('config.php');

if (isset($_SESSION['logado'])) {

  //Dados
  $id = $_SESSION['id_user'];
  //Busca no banco de dados o id do user logado
  $resultado = pg_query($connect, "SELECT * FROM usuario WHERE id_user='$id'");
  //transforma a variavel resultado em array 
  $dados = pg_fetch_array($resultado);
  //fechando a conexão depois de armazenar os dados


}

?>

<html>
<!--Head e header da página, contendo os "links" pré-estabelecidos de estilos, scripts [...] e o menu principal -->

<head>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">



  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link rel="stylesheet" type="text/css" href="./css/main.css">


</head>

<!-- Título com o nome de usuário -->

<title> <?php if (isset($_SESSION['logado'])) {
          echo $dados['nome_user'];
        } ?> </title>
<link rel="icon" type="image/x-icon" href="img/rockxaba_icon.png">

<header id="header">

  <div class="navbar-header">


    <?php if (!isset($_SESSION['logado'])) : ?>
      <img class="logo" width=100px 10%; weight=100px 10%; src="img/rockxaba_icon.png" alt="logo" id="logo-entrar"> </a>
      <ul class="nav-list">

        <li><a href="index.php">HOME</a></li>
        <li><a href="about.php">SOBRE</a></li>
        <li><a href="artistas.php">ARTISTAS</a></li>
        <li><a href="lojas.php"> LOJAS </a></li>
      </ul>

      <ul class="nav-list-entrar">
        <li class="dropbtn"><a href="login.php"> ENTRAR </a></li>
      </ul>

    <?php elseif (isset($_SESSION['logado'])) :  ?>
      
      <img class="logo" width=100px 10%; weight=100px 10%; src="img/rockxaba_icon.png" alt="logo" id="logo-logado"> </a>
      <ul class="nav-list">

        <li><a href="index.php">HOME</a></li>
        <li><a href="about.php">SOBRE</a></li>
        <li><a href="artistas.php">ARTISTAS</a></li>
        <li><a href="lojas.php"> LOJAS </a></li>
      </ul>

      <div class="dropdown">
        <li class="dropbtn" id="nome-perfil"> <?php echo $dados['nome_user']; ?></li>
        <div class="dropdown-content">
          <a href="perfil.php">Perfil</a>
          <a href="contato.php">Suporte</a>
          <a href="cadastro_bandas.php">Quero ser Artista</a>
          <a href="cadastro_bandas_admin.php">Quero ser Artista (Admin)</a>
          <a href="editar_perfil.php">Editar Perfil</a>

          <a href="?sair">Sair</a>
        </div>

      <?php endif; ?>
      </li>
      </ul>


</header>


<body>

  <script type="text/javascript" src="js/mobile-navbar.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>