<?php

function enviarComentario($connect) {
    if (isset($_POST["submit"])) {
    
        $id = $_GET["myid"];
        $mensagem = mysqli_real_escape_string($connect, $_POST["mensagem"]);
        $FK_USUARIO_id_user = mysqli_real_escape_string($connect, $_POST["FK_USUARIO_id_user"]);
        $date_coment = mysqli_real_escape_string($connect, $_POST["date_coment"]);
    
        $sql = mysqli_query($connect, "INSERT INTO comentario_artista (dsc_coment, date_coment, FK_USUARIO_id_user, FK_ARTISTA_id_artista, FK_TIPO_COMENTARIO_id_tipo_coment	
        ) Values ('" . $mensagem . "','". $date_coment . "' ,'". $FK_USUARIO_id_user . "','". $id . "', 1)");
        
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        exit();
    
       
    
    }

   
}

function enviarResposta($connect) {
    if (isset($_POST["respo"])) {
    
        $id = $_GET["myid"];
        $id_coment = $rows['id_coment'];
        $resp = mysqli_real_escape_string($connect, $_POST["resp"]);
        $FK_USUARIO_id_user = mysqli_real_escape_string($connect, $_POST["FK_USUARIO_id_user"]);
        $date_coment = mysqli_real_escape_string($connect, $_POST["date_coment"]);
    
        $sql = mysqli_query($connect, "INSERT INTO comentario_artista (dsc_coment, date_coment, FK_USUARIO_id_user, FK_ARTISTA_id_artista, FK_TIPO_COMENTARIO_id_tipo_coment	
        ) Values ('" . $resp . "','". $date_coment . "' ,'". $FK_USUARIO_id_user . "','". $id . "', 2)");




        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        exit();
    
       
    
    }

   
}




function editarPerfil($connect) {
    /*Se o botão de Submit for acionado, define as seguintes variáveis e as entrega para o banco através do método
POST*/
if (isset($_POST["submit"])) {
    $nome_user = mysqli_real_escape_string($connect, $_POST["nome_user"]);
    $dsc_user = mysqli_real_escape_string($connect, $_POST["dsc_user"]);

/*Se o usuário estiver devidamente logado, define as seguintes variáveis e as entrega para o banco através do método
POST*/
    if(isset($_SESSION['logado'])) {
        $photo_name = mysqli_real_escape_string($connect, $_FILES["photo"]["name"]);
        $photo_tmp_name = $_FILES["photo"]["tmp_name"];
        $photo_size = $_FILES["photo"]["size"];
        $photo_new_name = rand() . $photo_name;

/*Se o tamanho da foto for maior que 5MB, emite um erro. Do contrário, permite a alteração no banco*/
        if ($photo_size > 5242880) {
            echo "<script>alert('Tamanho de arquivo excedido (Máximo: 5MB');</script>";
        } else {
            $sql = "UPDATE usuario SET nome_user='$nome_user', dsc_user='$dsc_user' WHERE id_user='{$_SESSION["id_user"]}'";
            $result = mysqli_query($connect, $sql);

/*Se o tamanho do arquivo for 0mb (inexistente), atualiza o perfil sem a foto. Do contrário, atualiza com 
a foto*/
            if ($photo_size == 0) {
                    echo "<script>alert('O perfil foi atualizado com sucesso! (foto não alterada)');</script>";

            } else{
                if ($result) {
                    $sql = "UPDATE usuario SET  photo_user ='$photo_new_name' WHERE id_user='{$_SESSION["id_user"]}'";
                    $result = mysqli_query($connect, $sql);
                echo "<script>alert('O perfil foi atualizado com sucesso! (foto alterada)');</script>";
                
                move_uploaded_file($photo_tmp_name, "uploads/" . $photo_new_name);
            
            }}

        }
    } else {
        echo "<script>alert('Não foi possível atualizar o perfil. Por favor, tente novamente.');</script>";
    }
}
}
