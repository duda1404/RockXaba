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

if(isset($_SESSION['logado'])){

  //Dados
  $id = $_SESSION['id_user'];
  //Busca no banco de dados o id do user logado
  $resultado = mysqli_query($connect,"SELECT * FROM usuario WHERE id_user='$id'");
  //transforma a variavel resultado em array 
  $dados = mysqli_fetch_array($resultado);
  //fechando a conexão depois de armazenar os dados


}
  
  ?>

<html>
<!--Head e header da página, contendo os "links" pré-estabelecidos de estilos, scripts [...] e o menu principal -->

<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:400">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900">


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,200;1,700&display=swap" rel="stylesheet">
    
    
    
  </head>

  <!-- Título com o nome de usuário -->

  <title> <?php if(isset($_SESSION['logado'])){echo $dados['nome_user'];}?> </title>
  <link rel="icon" type="image/x-icon" href="img/rockxaba_icon.png">

    <header>
      <nav>
        <a class="logo" href="index.php">RockXaba</a> 
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
        <ul class="nav-list">
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">Sobre</a></li>
          <li><a href="artistas.php">Artistas</a></li>
          <li><a href="follow.php">Siga-nos</a></li>

<?php if(!isset($_SESSION['logado'])): ?>

  <li class="dropbtn"><a href="login.php">Fazer login</a></li>

<?php elseif(isset($_SESSION['logado'])):  ?>  
      
      <div class="dropdown">
        <li class="dropbtn"> <?php echo $dados['nome_user']; ?></li>
        <div class="dropdown-content">
          <a href="perfil.php">Perfil</a>
          <a href="contato.php">Suporte</a>
          <a href="cadastro_bandas.php">Quero ser Artista</a>
          <a href="editar_perfil.php">Editar Perfil</a>
          <a href="artistas.php">Artistas</a>
          <a href="?sair">Sair</a>
      </div>

  <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>


<body>

<script type="text/javascript" src="js/mobile-navbar.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




