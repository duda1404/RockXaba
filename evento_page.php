<?php
ob_start();
include 'header.php';
include 'funcoes.php';
?>

<section class="evento_body">
    <div class="foto-titulo-evento">
        <h3 id="nome-evento"> FESTIVAL ORGAS MÃOZINHA </h3>
    </div>
    <div class="info-comentarios-evento">
        <div class="curtir-views-comentarios">
            <div class="botao-views-curtidas">
                <button class="curtir-evento"> CURTIR </button>
                <div class="views-curtidas">
                    <p id="views-evento"> 1023 views </p>
                    <p id="curtidas-evento"> 145 curtidas </p>
                </div>
            </div>
            <div class="comentarios">

            </div>
        </div>
        <div class="localizacao-mapa-evento">
            <div class="bandas-evento">
                <p class="titulo-bandas-horario-evento"> BANDAS: </p>
                <p class="nome-bandas-horario-evento"> NaCartola, Sporro Grosso, Tubarão Complex, CATACLISMA </p>
            </div>
            <div class="horario-data-evento">
                <p class="titulo-bandas-horario-evento"> HORÁRIO E DATA </p>
                <p class="nome-bandas-horario-evento"> 20:00 22/07 </p>
            </div>
            <div class="caixa-localizacao">
                <p class="titulo-bandas-horario-evento" id="local"> LOCAL </p>
                <div class="mapouter">
                    <div class="gmap_canvas"><iframe width="350" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org">123movies</a><br>
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
</section>
</body>

</html>