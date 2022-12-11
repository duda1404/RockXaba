<?php
ob_start();
include 'header.php';
include 'funcoes.php';
?>

<!-- Texto e imagem do artista/banda-->

<body class="rexx">
    <?php
    $id = $_GET["myid"];

    /*Define um template vazio no HTML, do qual será preenchido de acordo com os dados do artista cadastrado.
no banco. */
    $image_query = pg_query($connect, "select artista.id_artista, artista.nome_artista, 
    artista.dsc_artista, artista.link_play, artista.cor_artista, foto_artista.photo_artista, artista.contato, artista.nome_insta from artista inner join
    foto_artista on artista.id_artista = foto_artista.FK_ARTISTA_id_artista	where $id = artista.id_artista and foto_artista.logo_foto = 'logo'");

    while ($rows = pg_fetch_array($image_query)) {

        $nome_artista = $rows['nome_artista'];
        $dsc_artista = $rows['dsc_artista'];
        $link = $rows['link_play'];
        $logo = $rows['photo_artista'];
        $cor_artista = $rows['cor_artista'];
        $contato = $rows['contato'];
        $nome_insta = $rows['nome_insta'];


    ?>
        <div class="main-rexx">
            <div class="container-slide">
          
<div id="sliderr" class="sliderr">
<div class="wrapperr">
<div id="items" class="items">
  <span class="slidee">Slide 1</span>
  <span class="slidee">Slide 2</span>
  <span class="slidee">Slide 3</span>
  <span class="slidee">Slide 4</span>
  <span class="slidee">Slide 5</span>
</div>
</div>
<a id="prev" class="control prev"></a>
<a id="next" class="control next"></a>
</div>


                
                <div class="contato-artista">
                    <div class="titulo-contato"> CONTATOS DO ARTISTA </div>
                    <div class="telefone-email">
                        <div class="texto"> Email: </div>
                        <div class="email"><?php echo $contato; ?></div>
                    </div>
                    <?php if (!empty($nome_insta)) { ?>
                        <div class="texto" id="texto-redes"> Redes Sociais </div>
                        <div class="redes">
                            <a href="https://www.instagram.com/<?php echo $nome_insta; ?>/">
                                <img id="rede-icone2" src="img/instagram.png">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div id="comentarios-caixa-artista-evento" style="background-color: <?php echo $cor_artista ?>; backdrop-filter: blur(2px)">
                    <div class="sessao-comentarios" id="sessao-comentarios1">

                        <?php $resultadon = pg_query($connect, "SELECT usuario.nome_user, usuario.photo_user, 
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
                                    <img class="foto-usuario" id="foto-perfil-comentario" src="uploads/<?php echo $photo_user; ?>">
                                </div>
                                <div class="foto-nome-data-horario">
                                    <h5> <?php echo $nome_userr; ?>_</h5>
                                    <span> <?php echo $date_coment; ?> </span>
                                    <button class="fechar-aba-respostas" onclick="funcaoFechar()"><img id="icone-fechar-aba" src="img/close-outline.svg" alt="Fechar aba de comentários"></button>
                                </div>
                            </div>
                            <p id="texto-notificacao"> <?php echo $coment; ?> </p>
                            <div class="curtir-comentario">
                                <button class="ver-respostas-responder-curtir" id="responder" onclick="responderComentario()"> Responder </button>
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
                    <form method="POST" action="<?php enviarComentario($connect) ?>">
                        <input type='hidden' name='FK_USUARIO_id_user' value="<?php echo $dados['id_user']; ?>">
                        <input type='hidden' name='date_coment' value="<?php echo date('Y-m-d H:i:s') ?>">
                        <div class="caixa-enviar-comentario" id="caixa-enviar">
                            <textarea id="text-area" class="input-comentario" name="mensagem" placeholder="digite aqui..."></textarea>
                            <button id="enviar-texto" name="submit"> ENVIAR </button>
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

                        document.getElementById('text-area').focus().scrollIntoView({
                            behavior: 'smooth'
                        });
                    }

                    function responderComentariosessao1() {

                        document.getElementById("sessao-comentarios1").style.display = "none";
                        document.getElementById("sessao-comentarios2").style.display = "block";
                        document.getElementById('text-area').focus().scrollIntoView({
                            behavior: 'smooth'
                        });

                    }
                </script>
            </div>


            <div class="rexx-text">
                <div class="logo-titulo-artista" id="theDiv">
                    <h3 id="nome-artista"> <span style="background-color: <?php echo $cor_artista; ?>; box-shadow: 0px 5px 20px 0px <?php echo $cor_artista; ?>, 0px 0px 0px 7px <?php echo $cor_artista; ?>;"> <?php echo $nome_artista; ?> </span></h3>
                    <div class="profile-card__img" id="logo-artista" style="box-shadow: 0px 5px 50px 0px <?php echo $cor_artista; ?>, 0px 0px 0px 7px <?php echo $cor_artista; ?>;">
                        <img src="uploads/<?php echo $photo ?>" alt="Logo do Artista">
                    </div>
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

        <script type="text/javascript" src="js/script.js"></script>


</body>

</html>