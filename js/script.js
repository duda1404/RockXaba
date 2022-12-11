
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

function reativarConta(delUrl) {

  if (confirm("Você deseja reativar sua conta?")) {

    document.location = delUrl;
  
  } else {

    document.location = 'login.php';
  

  }
}