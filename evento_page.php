<?php
ob_start();
include 'header.php';
include 'funcoes.php';

/*  strtoupper() */

$idEvento = $_GET["myid"];

/* background: -webkit-linear-gradient(-135deg,#c850c0, #0099f9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent; */

?>

<?php
/*Define um template vazio no HTML, do qual será preenchido de acordo com os dados dos artistas cadastrados.
no banco. Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
$image_query = pg_query($connect, "select even.id_evento, even.nome_evento, even.dsc_evento, even.google_maps, even.local_evento, even.dat_evento, 
    even.dat_limite_ingresso, even.dat_inicio_ingresso, even.cor_evento, even.preco_evento, even.artistas, ft.photo_evento from evento even inner join foto_evento ft
    on ft.fk_evento_id_evento = even.id_evento where even.id_evento = $idEvento and ft.front_page = 'fundo'");
while ($rows = pg_fetch_array($image_query)) {

    $id_evento = $rows['id_evento'];
    $nome_evento = $rows['nome_evento'];
    $local_evento = $rows['local_evento'];
    $dsc_evento = $rows['dsc_evento'];
    $google_maps = $rows['google_maps'];
    $data_evento = $rows['dat_evento'];
    $dat_limite_ingresso = $rows['dat_limite_ingresso'];
    $dat_inicio_ingresso = $rows['dat_inicio_ingresso'];
    $cor_evento = $rows['cor_evento'];
    $artistas = $rows['artistas'];
    $preco_evento = $rows['preco_evento'];
    $foto_fundo = $rows['photo_evento'];
    $row_artistas_rockxaba = NULL;
    $rows_artistas = NULL;

    $array_artistas = explode(",", $artistas);

    $fileCount = count($array_artistas);

    $a = 0;
    $b = 0;

    for ($i = 0; $i < $fileCount; $i++) {

        $subject = $array_artistas[$i];
        $artista_nome = trim($subject);
        $artistas_query = pg_query($connect, "select id_artista, nome_artista from artista where nome_artista ILIKE '$artista_nome'");
        $rows_artistas = pg_fetch_array($artistas_query);

        if ($rows_artistas != NULL) {

            $row_artistas_rockxaba[$a] = $rows_artistas['nome_artista'];
            $row_id_artista[$a] = $rows_artistas['id_artista'];

            $a = $a + 1;

            $array_artistas[$i] = NULL;
        }
    }

?>

    <body class="evento_body">
        <div class="foto-titulo-evento" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('uploads/<?php echo $foto_fundo; ?>'); background-size: 100% 100%;">
            <h3 id="nome-evento" style="background-color: <?php echo $cor_evento; ?>;
  box-shadow: 0px 0px 35px 0px <?php echo $cor_evento; ?>, 0px 0px 15px 0px <?php echo $cor_evento; ?> inset;"><?php echo strtoupper($nome_evento); ?></h3>
        </div>
        <div class="info-comentarios-evento" style="color: <?php echo $cor_evento; ?>; text-shadow: 0px 1px 10px <?php echo $cor_evento; ?>;">
            <div class="curtir-views-comentarios">
                <div class="botao-views-curtidas">
                    <div id="slider" class="slider" style="margin-top: 2vmax; left: 35%;">
                        <div class="wrapperr">
                            <div id="items" class="items">
                                <?php
                                $photo_query = pg_query($connect, "select photo_evento from foto_evento where fk_evento_id_evento = $id_evento");
                                while ($fotos = pg_fetch_array($photo_query)) {
                                    $foto = $fotos['photo_evento'];

                                ?>
                                    <span class="slide"> <img src="uploads/<?php echo $foto; ?>" /> </span>
                                <?php } ?>
                            </div>

                        </div>
                        <a id="prev" class="control prev"></a>
                        <a id="next" class="control next"></a>
                    </div>
                    <div class="bandas-evento">
                        <p class="titulo-bandas-horario-evento"> PREÇO DA ENTRADA: </p>
                        <p class="nome-bandas-horario-evento"><?php echo $preco_evento; ?></p>
                    </div>
                    <div class="bandas-evento">
                        <p class="titulo-bandas-horario-evento"> INÍCIO E FIM DA VENDA DE INGRESSOS: </p>
                        <p class="nome-bandas-horario-evento"> <?php echo $dat_inicio_ingresso; ?> / <?php echo $dat_limite_ingresso; ?> </p>
                    </div>
                    <div class="bandas-evento">
                        <p class="titulo-bandas-horario-evento"> DESCRIÇÃO DO EVENTO: </p>
                        <p class="nome-bandas-horario-evento"> <?php echo strtoupper($dsc_evento); ?></p>
                    </div>
                </div>
            </div>
            <div class="localizacao-mapa-evento">
                <?php
                $_SESSION['id_usuario'] = $id;
                $_SESSION['nome_usuario'] = $dados['nome_user'];
                $_SESSION['id_evento'] = $id_evento;
                $_SESSION['nome_evento'] = $nome_evento;
                $_SESSION['email_usuario'] = $dados['email_user'];

                ?>
                <button class="reportar" onclick="reportaEvento()"> Reportar Evento </button>
                <div class="bandas-evento">
                    <p class="titulo-bandas-horario-evento"> BANDAS/ARTISTAS: </p>
                    <p class="nome-bandas-horario-evento"><?php

                                                            if ($row_artistas_rockxaba != NULL) {

                                                                $fileCount = count($row_artistas_rockxaba);

                                                                for ($i = 0; $i < $fileCount; $i++) {

                                                            ?><span id="rockxaba-artista" style="background: -webkit-linear-gradient(-135deg,#c850c0, #0099f9);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    text-shadow: none;"><a href="artista_page.php?myid=<?php echo $row_id_artista[$i]; ?>"><?php echo $row_artistas_rockxaba[$i] . ', ' ?></a></span> <?php
                                                                                                                                                                    }
                                                                                                                                                                }

                                                                                                                                                                if ($array_artistas != NULL) {

                                                                                                                                                                    echo implode(", ", $array_artistas);
                                                                                                                                                                }

                                                                                                                                                                        ?></p>
                </div>
                <div class="horario-data-evento">
                    <p class="titulo-bandas-horario-evento"> HORÁRIO E DATA </p>
                    <p class="nome-bandas-horario-evento"><?php echo $data_evento; ?></p>
                </div>
                <div class="caixa-localizacao">
                    <p class="titulo-bandas-horario-evento" id="local"> LOCAL </p>
                    <p class="titulo-bandas-horario-evento" id="local"><?php echo strtoupper($local_evento); ?> </p>
                    <div class="mapouter">
                        <div class="gmap_canvas"><iframe width="350" height="300" id="gmap_canvas" src="<?php echo $google_maps; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br>
                            <style>
                                .mapouter {
                                    position: relative;
                                    text-align: right;
                                    height: 300px;
                                    width: 350px;
                                    margin-left: 12vmax;
                                }
                            </style><a href="https://www.embedgooglemap.net"></a>
                            <style>
                                .gmap_canvas {
                                    overflow: hidden;
                                    background: none !important;
                                    height: 300px;
                                    width: 350px;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </body>
<?php } ?>
<script type="text/javascript" src="js/script.js"></script>


</html>