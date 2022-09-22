<?php 
  include 'header.php';
?>

</head>
<body class = "body_caption">


	<div class="content">
		<h1>CONHEÇA NOVAS BANDAS E ARTISTAS</h1>
		<h3>Quem sabe você não descobre uma nova música favorita?</h3>
	</div>


	<div class="container-a2">
	<?php		
	/*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/ 
				$image_query = pg_query($connect,"select artista.id_artista, artista.nome_artista, 
				artista.dsc_artista, artista.link_play, foto_artista.photo_artista from artista inner join
				foto_artista on artista.id_artista = foto_artista.FK_ARTISTA_id_artista order by artista.dat_add_artista desc");
				while($rows = pg_fetch_array($image_query)){
					$id_artista = $rows['id_artista'];
					$nome_artista = $rows['nome_artista'];
					$photo = $rows['photo_artista'];
				?>

		<ul class="caption-style-2">
			<li>
			<a href="artista_page.php?myid=<?php echo $id_artista; ?>" target="new window"> 
			<img src="uploads/<?php echo $photo; ?>" alt="" title="<?php echo $nome_artista; ?>"/>
				<div class="caption">
					<div class="blur"></div>
					<div class="caption-text">
						<h1><?php echo $nome_artista; ?></h1>
						<p>Descrição</p>
					</div>
				</div>
				</a> 
			</li>
			<?php
                }

            ?>

		</ul>
	</div>
</body>
</html>