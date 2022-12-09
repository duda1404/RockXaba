
function site2(){

  window.location.replace("http://localhost/RockXaba/Artistas/");
}

function curtirEvento(){

  const btn = document.getElementById('curtir-evento');

  if(btn.innerText=="CURTIR"){
    btn.innerText="CURTIDO";
   }
 else{
   btn.innerText="CURTIR";
   }

}