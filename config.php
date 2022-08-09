<?php

    /* Variáveis que referenciam o Banco de Dados (nome do Host, nome do user, senha do user e nome do banco de dados) */

    $servername = 'localhost:3306';
    $username = 'root';
    $password = 'usbw';
    $db_name = 'rock_xaba2';

    /* Variável de conexão */

    $connect = mysqli_connect($servername,$username,$password,$db_name);

    //codifica com o caracteres ao manipular dados do banco de dados
    //mysqli_set_charset($connect, "utf8");
    
    if(mysqli_connect_error()):
        echo "Falha na conexão: ". mysqli_connect_error();
    endif;
    
?>