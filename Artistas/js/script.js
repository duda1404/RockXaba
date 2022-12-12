 
 // =============================== JS DO SELETOR DE GÊNEROS MUSICAIS ===============================

    new MultiSelectTag('generos') // id

 // =========================== JS DOS INPUTS LINK_SPOTIFY E LINK_YOUTUBE ===========================

 //JavaScript que chama o campo de link do Spotify ou link do YouTube

 function chamaCampo() {

     var divSpotify = document.getElementById('link-spotify');
     var divYouTube = document.getElementById('link-youtube');

     if (document.getElementById('spotify').checked) {
         //Campo do Spotify foi escolhido

         //Fecha o campo do YouTube se ele está aberto
         divYouTube.style.display = 'none';
         //Apaga o campo do YouTube caso tenha sido escrito nele
         divYouTube.value="";
         //Abre o campo do Spotify
         divSpotify.style.display = 'block';

     } else if (document.getElementById('youtube').checked) {
         //Campo do YouTube foi escolhido

         //Fecha o campo do Spotify se ele está aberto
         divSpotify.style.display = 'none';
          //Apaga o campo do Spotify caso algo tenha sido escrito nele
         divSpotify.value="";
         //Abre o campo do YouTube
         divYouTube.style.display = 'block';


     }
 }

/* FUNÇÃO QUE DESATIVA E ATIVA EVENTOS */
 
 function desativaAtiva(delUrl){

    document.location = delUrl;
 }

 