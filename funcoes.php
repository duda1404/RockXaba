<?php


function enviarComentario($connect) {
    if (isset($_POST["submit"])) {
    
        $id = $_GET["myid"];
        $mensagem = mysqli_real_escape_string($connect, $_POST["mensagem"]);
        $FK_USUARIO_id_user = mysqli_real_escape_string($connect, $_POST["FK_USUARIO_id_user"]);
        $date_coment = mysqli_real_escape_string($connect, $_POST["date_coment"]);
    
        $sql = "INSERT INTO comentario_artista (dsc_coment, date_coment, FK_USUARIO_id_user) Values ('" . $mensagem . "','". $date_coment . "' ,'". $FK_USUARIO_id_user . "')";
        $result = mysqli_query($connect, $sql);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        exit();
    
       
    
    }

   
}

