<?php
ob_start();
include 'header.php';
include 'funcoes.php';
?>

<!-- Texto e imagem do artista/banda-->
<section class="rexx">
    <?php
    $id = $_GET["myid"];

    /*Define um template vazio no HTML, do qual será preenchido de acordo com os dados do artista cadastrado.
no banco. */
    $image_query = pg_query($connect, "select artista.id_artista, artista.nome_artista, 
    artista.dsc_artista, artista.link_play, foto_artista.photo_artista from artista inner join
    foto_artista on artista.id_artista = foto_artista.FK_ARTISTA_id_artista	where $id = id_artista");

    while ($rows = pg_fetch_array($image_query)) {
        $nome_artista = $rows['nome_artista'];
        $dsc_artista = $rows['dsc_artista'];
        $link = $rows['link_play'];
        $photo = $rows['photo_artista'];

    ?>
        <div class="main-rexx">
            <img class="image_rex" src="img/mortiz_foto.png" id="foto-artista">
            <div class="rexx-text">
                <div class="logo-titulo-artista">
                    <h3 id="nome-artista"><span><?php echo $nome_artista; ?></span></h3>
                    <div class="profile-card__img" id="logo-artista">
                        <img src="uploads/<?php echo $photo ?>" alt="Logo do Artista">
                    </div>
                </div>
                <div class="info-artista">
                    <p class="seguidores"> 650 seguidores </p>
                    <p class="seguindo"> 1023 views </p>
                    <p class="curtidas"> 145 curtidas </p>
                </div>
                <div class="seguir-curtir">
                    <a id="curtida" href="" class="curtida-seguir">
                        <img id="curtida" src="img/guitar-pick.svg" width="35px" height="45px" class="curtida-seguir" alt="Botão de curtida">
                    </a>
                    <button id="seguir" class="curtida-seguir"> SEGUIR </button>
                </div>
                <div class="generos">
                    <p class="gen-artista"> INDIE </p>
                    <p class="gen-artista"> INDIE-ROCK </p>
                    <p class="gen-artista"> ALTERNATIVO </p>
                    <p class="gen-artista"> GARAGE ROCK </p>
                </div>
                <p id="dsc-artista"> <?php echo $dsc_artista; ?> </p>


                <!--Classe do embed do Spotify -->
                <div class="spotify_rex">
                    <div class="spotify_2">
                        <iframe style="border-radius:12px" src="<?php echo $link; ?>" style="border-radius:12px; top: 0; right: 0; width: 184%; height: 100%; position: absolute;" width="100%" height="380" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                    </div>
                <?php
            }
                ?>

                </div>
            </div>

        </div>

        <!--Sessão de enviar comentários-->
        <div class="container mb-5 mt-5">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center mb-5">
                            Comentários
                        </h3>
                        <!-- Sessão de comentários, contendo a função PHP de enviar comentário -->
                        <div class="row">
                            <div class="col-md-12">

                                <form method="POST" action="<?php enviarComentario($connect) ?>">
                                    <input type='hidden' name='FK_USUARIO_id_user' value="<?php echo $dados['id_user']; ?>">
                                    <input type='hidden' name='date_coment' value="<?php echo date('Y-m-d H:i:s') ?>">
                                    <textarea rows="10" cols="100" name='mensagem' placeholder='Digite seu comentário'></textarea>

                                    <button class="button" type="submit" name="submit">Enviar</button>

                                </form>

                                <?php
                                /* Enquanto houver resultado da consulta no MYSQL, executará o loop que preenche as informações*/
                                $resultadon = pg_query($connect, "SELECT usuario.nome_user, usuario.photo_user, 
                                comentario_artista.dsc_coment, comentario_artista.date_coment, comentario_artista.id_coment
                                 FROM usuario INNER JOIN comentario_artista ON usuario.id_user = comentario_artista.FK_USUARIO_id_user 
                                 INNER JOIN artista ON artista.id_artista = comentario_artista.FK_ARTISTA_id_artista
                                 WHERE FK_ARTISTA_id_artista = $id and reply_of is null");


                                while ($rows = pg_fetch_array($resultadon)) {
                                    $id_coment = $rows['id_coment'];
                                    $nome_userr = $rows['nome_user'];
                                    $photo_user = $rows['photo_user'];
                                    $coment = $rows['dsc_coment'];
                                    $date_coment = $rows['date_coment'];
                                ?>


                                    <script>
                                        function myFunction(id) {
                                            var x = document.getElementById(id);

                                            if (x.style.display === "none") {
                                                x.style.display = "block";
                                            } else {
                                                x.style.display = "none";

                                            }
                                        }
                                    </script>

                                    <!--Sessão de comentários-->
                                    <div class="media">
                                        <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="uploads/<?php echo $photo_user ?>">
                                        <div class="media-body">
                                            <div class="row">
                                                <div class="col-8 d-flex">
                                                    <h5><?php echo $nome_userr ?></h5>
                                                    <span> - <?php echo $date_coment ?></span>
                                                </div>
                                                <div class="col-4">
                                                </div>
                                            </div>

                                            <?php echo $coment ?>

                                            <!--Caixa de responder comentário-->
                                            <div class="reply-box">

                                                <div class="responder" id="<?php echo $id_coment; ?>" style="display:none;">

                                                    <form method="POST" action="<?php enviarResposta($connect) ?>">
                                                        <input type='hidden' name='reply_of' value="<?php echo $id_coment; ?>">
                                                        <input type='hidden' name='FK_USUARIO_id_user' value="<?php echo $dados['id_user']; ?>">
                                                        <input type='hidden' name='date_coment' value="<?php echo date('Y-m-d H:i:s') ?>">
                                                        <textarea rows="10" cols="100" name='resp' placeholder='Digite seu comentário'></textarea>
                                                        <button class="button" type="submit" name="respo">Enviar</button>

                                                    </form>

                                                </div>
                                                <div class="ulala">
                                                    <button id="" class="reply" type="button" onclick="myFunction(<?php echo $id_coment; ?>)">Responder</button>

                                                    <button id="" class="hid" type="button" onclick="myFunction(<?php echo $id_coment; ?>)">Cancelar</button>
                                                </div>

                                            </div>

                                            <?php
                                            $resultado_reply = pg_query($connect, "WITH RECURSIVE tree AS 
                                            ( select
            comentario_artista.dsc_coment, comentario_artista.date_coment, comentario_artista.id_coment, comentario_artista.reply_of, 
            lpad(id_coment::text, 2, '0') as path, usuario.nome_user, usuario.photo_user   

                                             FROM usuario INNER JOIN comentario_artista ON usuario.id_user = comentario_artista.FK_USUARIO_id_user 
            
                                             INNER JOIN artista ON artista.id_artista = comentario_artista.FK_ARTISTA_id_artista where id_artista = $id and reply_of is null
                                            
                                            union all 
                                            
                                            select 
            comentario_artista.dsc_coment, comentario_artista.date_coment, comentario_artista.id_coment, comentario_artista.reply_of,
            tree.path || '/' || comentario_artista.id_coment::text as path, usuario.nome_user, usuario.photo_user
                                            
                                             FROM usuario INNER JOIN comentario_artista ON usuario.id_user = comentario_artista.FK_USUARIO_id_user 
            
                                             INNER JOIN artista ON artista.id_artista = comentario_artista.FK_ARTISTA_id_artista, tree 
            
                                              WHERE comentario_artista.reply_of = tree.id_coment
                                            )
                                            SELECT * FROM tree where path like '$id_coment%' and reply_of is not null");


                                            while ($reply_array = pg_fetch_array($resultado_reply)) {
                                                $id_reply = $reply_array['id_coment'];
                                                $reply = $reply_array['dsc_coment'];
                                                $nome_user_reply = $reply_array['nome_user'];
                                                $data_reply = $reply_array['date_coment'];
                                                $photo_reply = $reply_array['photo_user'];

                                            ?>

                                                <!--Caixa de respostas-->
                                                <div class="media mt-4">
                                                    <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="uploads/<?php echo $photo_reply; ?>" /></a>
                                                    <div class="media-body">
                                                        <div class="row">
                                                            <div class="col-12 d-flex">

                                                                <h5><?php echo $nome_user_reply; ?></h5>
                                                                <span>- <?php echo $data_reply; ?></span>
                                                            </div>
                                                        </div>
                                                        <?php echo $reply ?>

                                                        <!--Caixa de responder resposta-->
                                                        <div class="reply-box">

                                                            <div class="responder" id="<?php echo $id_reply; ?>" style="display:none;">

                                                                <form method="POST" action="<?php enviarResposta($connect) ?>">
                                                                    <input type='hidden' name='reply_of' value="<?php echo $id_reply; ?>">
                                                                    <input type='hidden' name='FK_USUARIO_id_user' value="<?php echo $dados['id_user']; ?>">
                                                                    <input type='hidden' name='date_coment' value="<?php echo date('Y-m-d H:i:s') ?>">
                                                                    <textarea rows="10" cols="100" name='resp' placeholder='Digite seu comentário'></textarea>
                                                                    <button class="button" type="submit" name="respo">Enviar</button>

                                                                </form>

                                                            </div>
                                                            <div class="ulala">
                                                                <button id="" class="reply" type="button" onclick="myFunction(<?php echo $id_reply; ?>)">Responder</button>

                                                                <button id="" class="hid" type="button" onclick="myFunction(<?php echo $id_reply; ?>)">Cancelar</button>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>


                                            <?php
                                            }
                                            ?>

                                        </div>

                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
</section>




<script type="text/javascript" src="js/script.js"></script>


</body>

</html>