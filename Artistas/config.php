<?php

    /* Variáveis que referenciam o Banco de Dados (nome do Host, nome do user, senha do user e nome do banco de dados) */

    $servername = 'kesavan.db.elephantsql.com';
    $username = 'jrngkpyd';
    $password = '4_6AXCXvkopay3ZgpEABse8buFWXNJdI';
    $db_name = 'jrngkpyd';

    /* Variável de conexão */

    
    try {
        $dsn = "pgsql:host=$servername;port=5432;dbname=$db_name;";
        // make a database connection
        $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    } catch(PDOException $e){
        
        die("ERROR: Não foi possível conectar." . $e->getMessage());
    }
?>