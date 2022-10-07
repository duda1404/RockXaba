<?php

    /* Variáveis que referenciam o Banco de Dados (nome do Host, nome do user, senha do user e nome do banco de dados) */

    $servername = 'kesavan.db.elephantsql.com';
    $username = 'jrngkpyd';
    $password = '4_6AXCXvkopay3ZgpEABse8buFWXNJdI';
    $db_name = 'jrngkpyd';

    /* Variável de conexão */

    $connect = pg_connect("host=$servername dbname=$db_name user=$username password=$password") or die ("Não foi possível conectar ao servidor PostGreSQL");
    
    
?>