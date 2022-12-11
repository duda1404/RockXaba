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
			<input type="search" id="search-box" onkeyup="barraBusca()" placeholder="Buscar artista, banda, gênero..." />
		</form>

		<div class="select">
			<select name="ORDENAR" id="filtro" >
				<option selected disabled value="1">ORDENAR: </option>
				<option value="2" onclick="filtro()">ORDENAR: A-Z</option>
				<option value="3" onclick="filtro()">ORDENAR: LIKES</option>
			</select>
		</div>

	</div>

	<div class="container-a2">
		<ul class="caption-style-2" id="myUL">
			<?php
			/*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
			$image_query = pg_query($connect, "select art.id_artista, art.nome_artista, 
				art.dsc_artista, art.link_play from artista art inner join usuario userr on art.fk_usuario_id_user = userr.id_user where art.fk_situacao_id_sit = 1 and userr.fk_situacao_id_sit = 1 order by art.dat_add_artista desc");
			while ($rows = pg_fetch_array($image_query)) {
				$id_artista = $rows['id_artista'];
				$nome_artista = $rows['nome_artista'];
				$dsc_artista = $rows['dsc_artista'];

				$query_logo = pg_query($connect, "SELECT photo_artista FROM foto_artista WHERE fk_artista_id_artista = $id AND logo_foto = 'logo'");
				$logo_row = pg_fetch_array($query_logo);
				
				
				

			?>

				<li>
					<a href="artista_page.php?myid=<?php echo $id_artista; ?>" target="new window">
						<img src="uploads/" class="testando" alt="" title="<?php echo $nome_artista; ?>" name="<?php echo $nome_artista; ?>" />
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

		function filtro() {

			var select = document.getElementById('filtro');
			var value = select.options[select.selectedIndex].value;

			if (value == 2) {

				var list, i, switching, b, shouldSwitch;
				list = document.getElementById("myUL");
				switching = true;
				/* Make a loop that will continue until
				no switching has been done: */
				while (switching) {
					// Start by saying: no switching is done:
					switching = false;
					b = list.getElementsByTagName("img");
					// Loop through all list items:
					for (i = 0; i < (b.length - 1); i++) {
						// Start by saying there should be no switching:
						shouldSwitch = false;
						/* Check if the next item should
						switch place with the current item: */
						if (b[i].name.toLowerCase() > b[i + 1].name.toLowerCase()) {
							/* If next item is alphabetically lower than current item,
							mark as a switch and break the loop: */
							shouldSwitch = true;
							break;
						}
					}
					if (shouldSwitch) {
						/* If a switch has been marked, make the switch
						and mark the switch as done: */
						b[i].parentNode.insertBefore(b[i + 1], b[i]);
						switching = true;
					}
				}
			}
		}
	</script>

</body>

</html>