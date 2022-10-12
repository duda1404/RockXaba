<?php
include 'header.php';
?>

</head>

<body class="body_caption">


	<div class="content">
		<h3 id="titulo-lojas"> LOJAS </h3>
	</div>

	<div class="artista-buscar-filtrar">
		<form class=" clearfix searchform">
			<label for="search-box">
				<span class="fa fa-search fa-flip-horizontal fa-2x"></span>
			</label>
			<input type="search" id="search-box" placeholder="Buscar loja de artistas, bandas..." />
		</form>
		<div class="select">
			<select name="ORDENAR">
				<option selected disabled value="1">ORDENAR: </option>
				<option value="2">ORDENAR: A-Z</option>
			</select>
		</div>
	</div>

	<div class="container-a2">
		<ul class="caption-style-2">
			<?php
			/*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
			$image_query = pg_query($connect, "select artista.id_artista, artista.nome_artista, 
				artista.dsc_artista, artista.link_play, foto_artista.photo_artista from artista inner join
				foto_artista on artista.id_artista = foto_artista.FK_ARTISTA_id_artista order by artista.dat_add_artista desc");
			while ($rows = pg_fetch_array($image_query)) {
				$id_artista = $rows['id_artista'];
				$nome_artista = $rows['nome_artista'];
				$photo = $rows['photo_artista'];
				$dsc_artista = $rows['dsc_artista'];
			?>

				<li>
					<a href="artista_page.php?myid=<?php echo $id_artista; ?>" target="new window">
						<img src="uploads/<?php echo $photo; ?>" class="testando" alt="" title="<?php echo $nome_artista; ?>" />
					</a>
				</li>
			<?php
			}

			?>

		</ul>
	</div>
</body>

</html>