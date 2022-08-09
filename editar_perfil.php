<?php 

    include 'header.php';

    if(!isset($_SESSION['logado'])){

      header('Location: login.php?acao=negado');
    
    
    }

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
                echo "<script>alert('O perfil foi atualizado com sucesso!');</script>";
                
                move_uploaded_file($photo_tmp_name, "uploads/" . $photo_new_name);
            
            }}

        }
    } else {
        echo "<script>alert('Não foi possível atualizar o perfil. Por favor, tente novamente.');</script>";
    }
}

?>

<?php 
/*Define um template vazio no HTML, do qual será preenchido de acordo com as informações do usuário logado */ 
?>

<div class="wrapper">

			<div class="inner">
            <fieldset class = "fieldset ">
            <legend>Edite seu Perfil</legend>
        <form action="" method="post" enctype="multipart/form-data">
            <?php

/*Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações do usuário*/
            $sql = "SELECT * FROM usuario WHERE id_user='{$_SESSION["id_user"]}'";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>

<div class="imgg">
                    
                    <img class="photo_img" src="uploads/<?php echo $row["photo_user"]; ?>">
                    <label for="photo" class="img"> Alterar foto de perfil </label>
                        <input type="file" accept="image/*" id="photo" name="photo" >
                    </div>
					
					
					<label class="form-group">
						<input type="text" id="nome_user" name="nome_user" class="form-control"  value="<?php echo $row['nome_user']; ?>" required>
						<span>Usuário</span>
						
					</label>

					<label class="form-group">
						<input type="text" id="email_user" name="email_user" class="form-control" value="<?php echo $row['email_user']; ?>" >
						<span for="">Email</span>
						
					</label>
					
					
					
					<label class="form-group">
						<input type="text" id="dsc_user" name="dsc_user" class="form-control"  value="<?php echo $row['dsc_user']; ?>" >
						<span>Descrição</span>
						
					</label>

                    
                    <?php
                }
            }

            ?>

                    <label class="form-group">
					<button class="button" type="submit" name="submit">Salvar
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
                    </label>



					



				
		</div>
            

            <div>
            </fieldset>
        </form>
    </div>
</body>

</html>