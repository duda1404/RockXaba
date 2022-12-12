<?php
include 'header.php';
?>

</head>

<body class="body_caption">

	<div class="content">
		<h3> ARTISTAS </h3>
	</div>

	<div class="artista-buscar-filtrar">
		<div class="lupa">
			<img src="img/lupa.png" class="lupa-de-busca">
		</div>
		<form class=" clearfix searchform">
			<label for="search-box">
				<span class="fa fa-search fa-flip-horizontal fa-2x"></span>
			</label>
			<input type="search" id="search-box" onkeyup="barraBusca()" placeholder="Buscar artista ou banda..." />
		</form>
	</div>

	<div class="container-a2">
		<ul class="caption-style-2" id="myUL">
			<?php
			/*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
			$image_query = pg_query($connect, "select art.id_artista, art.nome_artista, 
				art.dsc_artista, art.link_play, fot.photo_artista from artista art inner join usuario userr on art.fk_usuario_id_user = userr.id_user inner join foto_artista fot on art.id_artista = fot.fk_artista_id_artista where art.fk_situacao_id_sit = 1 and userr.fk_situacao_id_sit = 1 AND logo_foto = 'logo' order by art.dat_add_artista desc");
			while ($rows = pg_fetch_array($image_query)) {
				$id_artista = $rows['id_artista'];
				$nome_artista = $rows['nome_artista'];
				$dsc_artista = $rows['dsc_artista'];

				$logo_artista = $rows['photo_artista'];
				
				

			?>

				<li>
					<a href="artista_page.php?myid=<?php echo $id_artista; ?>" target="new window">
						<img src="uploads/<?php echo $logo_artista; ?>" class="testando" alt="" title="<?php echo $nome_artista; ?>" name="<?php echo $nome_artista; ?>" />
					</a>
				</li>
			<?php
			}

			?>

		</ul>
	</div>

	<script>
		function barraBusca() {
			// Declare variables
			var input, filter, ul, li, a, i, txtValue;
			input = document.getElementById('search-box');
			filter = input.value.toUpperCase();
			ul = document.getElementById("myUL");
			li = ul.getElementsByTagName('li');

			// Loop through all list items, and hide those who don't match the search query
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("img")[0];
				txtValue = a.getAttribute('title');
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				} else {
					li[i].style.display = "none";
				}
			}
		}

		
	</script>

</body>

</html>