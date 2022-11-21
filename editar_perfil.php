<?php 

    include 'header.php';
    require 'funcoes.php';
    if(!isset($_SESSION['logado'])){

      header('Location: login.php?acao=negado');
    
    
    }

    editarPerfil($connect)

?>

<?php 
/*Define um template vazio no HTML, do qual será preenchido de acordo com as informações do usuário logado */ 
?>
<body class=editar_perfil>

<div class="wrapper">

			<div class="inner">
            <fieldset class = "fieldset ">
            <legend>Edite seu Perfil</legend>
        <form action="" method="post" enctype="multipart/form-data">
            <?php

/*Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações do usuário*/
            $sql = "SELECT * FROM usuario WHERE id_user='{$_SESSION["id_user"]}'";
            $result = pg_query($connect, $sql);
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
            ?>

<div class="imgg">
                    
                    <img class="photo_img" id="photo_img" src="uploads/<?php echo $row["photo_user"]; ?>">
                    <label for="photo" class="img"> Alterar foto de perfil </label>
                        <input type="file" accept="image/*" id="photo" name="photo" >
                       
                        <script> photo.onchange = evt => {
    const [file] = photo.files
    if (file) {
      photo_img.src = URL.createObjectURL(file)
    }
  }</script>
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
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>