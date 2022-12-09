<?php 

/* Se a request do método 'sair' existe (quando o usuário clica para sair do perfil), destrói a sessão */

    if (isset($_REQUEST['sair'])){

        session_destroy();
        header('Location: index.php?acao=sair');

    }