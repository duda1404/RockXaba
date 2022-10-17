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
    artista.dsc_artista, artista.link_play, artista.cor_artista, foto_artista.photo_artista from artista inner join
    foto_artista on artista.id_artista = foto_artista.FK_ARTISTA_id_artista	where $id = id_artista");

    while ($rows = pg_fetch_array($image_query)) {
        $nome_artista = $rows['nome_artista'];
        $dsc_artista = $rows['dsc_artista'];
        $link = $rows['link_play'];
        $photo = $rows['photo_artista'];
        $cor_artista = $rows['cor_artista'];

    ?>
        <div class="main-rexx">
            <div class="container-slide">
                <input type="radio" name="slider" id="item-1" checked>
                <input type="radio" name="slider" id="item-2">
                <input type="radio" name="slider" id="item-3">
                <input type="radio" name="slider" id="item-4">
                <div class="cards">
                    <label class="carta" for="item-1" id="song-1">
                        <img src="uploads/<?php echo $photo ?>" alt="song">
                    </label>
                    <label class="carta" for="item-2" id="song-2">
                        <img src="https://images.unsplash.com/photo-1559386484-97dfc0e15539?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1234&q=80" alt="song">
                    </label>
                    <label class="carta" for="item-3" id="song-3">
                        <img src="https://images.unsplash.com/photo-1533461502717-83546f485d24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60" alt="song">
                    </label>
                    <label class="carta" for="item-4" id="song-4">
                        <img src="uploads/51911615FdoYeMWXoAAI4WU.png" alt="song">
                    </label>
                </div>

                
                <div id="comentarios-caixa-artista-evento" style=" background: rgba(1,37,28,0.5); backdrop-filter: blur(2px)">
                    <div class="sessao-comentarios" id="sessao-comentarios1">
                        
                    <?php    $resultadon = pg_query($connect, "SELECT usuario.nome_user, usuario.photo_user, 
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

                        <div class="caixa-comentario">
                            <div class="comentarios-top">
                                <div class="foto-perfil">
                                    <img class="mr-3 rounded-circle" id="foto-perfil-comentario" src="uploads/<?php echo $photo_user; ?>">
                                </div>
                                <div class="foto-nome-data-horario">
                                    <h5> <?php echo $nome_userr; ?>_</h5>
                                    <span> <?php echo $date_coment; ?> </span>
                                </div>
                            </div>
                            <p id="texto-notificacao"> <?php echo $coment; ?> </p>
                            <div class="curtir-comentario">
                                <button class="ver-respostas-responder-curtir" id="ver-respostas" onclick="minhaFuncao()"> Ver respostas(54)</button>
                                <button class="ver-respostas-responder-curtir" id="responder" onclick="responderComentariosessao1()"> Responder </button>
                                <button class="ver-respostas-responder-curtir" id="curtir"><img id="imagem-curtida" src="img/guitar-pick.svg" alt="Botão de curtida"> 145</button>
                            </div>
                        </div>
                        
                       
                        <?php
                                            }
                                            ?>
                                            
                    </div>
                    
                 

                    <div class="sessao-comentarios" id="sessao-comentarios2" style="display:none">
                   
                        <div class="caixa-comentario" id="comentario-principal-aba-respostas">

                            <div class="comentarios-top">
                                <div class="foto-perfil">
                                    <img class="mr-3 rounded-circle" id="foto-perfil-comentario" src="uploads/<?php echo $photo_user; ?>">
                                </div>
                                <div class="foto-nome-data-horario">
                                    <h5> <?php echo $nome_userr; ?>_</h5>
                                    <span> <?php echo $date_coment; ?> </span>
                                    <button class="fechar-aba-respostas" onclick="funcaoFechar()"><img id="icone-fechar-aba" src="img/close-outline.svg" alt="Fechar aba de comentários"></button>
                                </div>
                            </div>
                            <p id="texto-notificacao"> <?php echo $coment; ?> </p>
                            <div class="curtir-comentario">
                                <button class="ver-respostas-responder-curtir" id="responder" onclick="responderComentario()" > Responder </button>
                                <button class="ver-respostas-responder-curtir" id="curtir"><img id="imagem-curtida" src="img/guitar-pick.svg" alt="Botão de curtida"> 145</button>
                            </div>
                        </div>
                       
                        <div id="respostas" class="sessao-comentarios">
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
                            <div class="caixa-comentario">
                                <div class=" comentarios-top">
                                <div class="foto-perfil">
                                    <img class="mr-3 rounded-circle" id="foto-perfil-comentario" src="uploads/<?php echo $photo_reply; ?>">
                                </div>
                                <div class="foto-nome-data-horario">
                                    <h5> <?php echo $nome_user_reply; ?>_</h5>
                                    <span> <?php echo $data_reply; ?> </span>

                                </div>
                            </div>
                            <p id="texto-notificacao"> <?php echo $reply; ?> </p>
                            <div class="curtir-comentario">
                                <button class="ver-respostas-responder-curtir" id="responder" onclick="responderComentario()"> Responder </button>
                                <button class="ver-respostas-responder-curtir" id="curtir"><img id="imagem-curtida" src="img/guitar-pick.svg" alt="Botão de curtida"> 145</button>
                            </div>
                        </div>

                        
                        <?php
                                            }
                                            ?>
                    </div>
                   
                </div>

                <div class="caixa-enviar-comentario" id="caixa-enviar">
                    <textarea id="text-area" class="input-comentario" placeholder="digite aqui..."></textarea>
                    <button id="enviar-texto"> ENVIAR </button>
                </div>
                
            </div>
            

            <script>
                function minhaFuncao() {
                    document.getElementById("sessao-comentarios1").style.display = "none";
                    document.getElementById("sessao-comentarios2").style.display = "block";
                }

                function funcaoFechar() {
                    document.getElementById("sessao-comentarios2").style.display = "none";
                    document.getElementById("sessao-comentarios1").style.display = "block";
                }

                function responderComentario() {

                    document.getElementById('text-area').focus().scrollIntoView({behavior: 'smooth' });
                }

                function responderComentariosessao1(){

                    document.getElementById("sessao-comentarios1").style.display = "none";
                    document.getElementById("sessao-comentarios2").style.display = "block";
                    document.getElementById('text-area').focus().scrollIntoView({ behavior: 'smooth' });
                    
                }
            </script>
        </div>


        <div class="rexx-text">
            <div class="logo-titulo-artista">
                <h3 id="nome-artista"> <span style="background-color: <?php echo $cor_artista; ?>; box-shadow: 0px 5px 20px 0px <?php echo $cor_artista; ?>, 0px 0px 0px 7px <?php echo $cor_artista; ?>;"> <?php echo $nome_artista; ?> </span></h3>
                <div class="profile-card__img" id="logo-artista" style="box-shadow: 0px 5px 50px 0px <?php echo $cor_artista; ?>, 0px 0px 0px 7px <?php echo $cor_artista; ?>;">
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
                <button id="seguir" style="background-color: <?php echo $cor_artista; ?>;
  box-shadow: 0px 5px 50px 0px <?php echo $cor_artista; ?>, 0px 0px 0px 7px <?php echo $cor_artista; ?>;" class="curtida-seguir"> SEGUIR </button>
            </div>
            <div class="generos">
                <p class="gen-artista"> INDIE </p>
                <p class="gen-artista"> INDIE-ROCK </p>
                <p class="gen-artista"> ALTERNATIVO </p>
                <p class="gen-artista"> GARAGE ROCK </p>
            </div>
            <p id="dsc-artista" style="color:<?php echo $cor_artista; ?>; text-shadow: 2px 2px 12px #<?php echo $cor_artista; ?>;"> <?php echo $dsc_artista; ?> </p>


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


</section>




<script type="text/javascript" src="js/script.js"></script>


</body>

</html>