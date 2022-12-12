
var slider = document.getElementById('slider'),
sliderItems = document.getElementById('items'),
prev = document.getElementById('prev'),
next = document.getElementById('next');

slide(slider, sliderItems, prev, next);

function slide(wrapperr, items, prev, next) {
var posX1 = 0,
  posX2 = 0,
  posInitial,
  posFinal,
  threshold = 100,
  slides = items.getElementsByClassName('slide'),
  slidesLength = slides.length,
  slideSize = items.getElementsByClassName('slide')[0].offsetWidth,
  firstSlide = slides[0],
  lastSlide = slides[slidesLength - 1],
  cloneFirst = firstSlide.cloneNode(true),
  cloneLast = lastSlide.cloneNode(true),
  index = 0,
  allowShift = true;

// Clone first and last slide
items.appendChild(cloneFirst);
items.insertBefore(cloneLast, firstSlide);
wrapperr.classList.add('loaded');

// Mouse and Touch events
items.onmousedown = dragStart;

// Touch events
items.addEventListener('touchstart', dragStart);
items.addEventListener('touchend', dragEnd);
items.addEventListener('touchmove', dragAction);

// Click events
prev.addEventListener('click', function () { shiftSlide(-1) });
next.addEventListener('click', function () { shiftSlide(1) });

// Transition events
items.addEventListener('transitionend', checkIndex);

function dragStart (e) {
e = e || window.event;
e.preventDefault();
posInitial = items.offsetLeft;

if (e.type == 'touchstart') {
  posX1 = e.touches[0].clientX;
} else {
  posX1 = e.clientX;
  document.onmouseup = dragEnd;
  document.onmousemove = dragAction;
}
}

function dragAction (e) {
e = e || window.event;

if (e.type == 'touchmove') {
  posX2 = posX1 - e.touches[0].clientX;
  posX1 = e.touches[0].clientX;
} else {
  posX2 = posX1 - e.clientX;
  posX1 = e.clientX;
}
items.style.left = (items.offsetLeft - posX2) + "px";
}

function dragEnd (e) {
posFinal = items.offsetLeft;
if (posFinal - posInitial < -threshold) {
  shiftSlide(1, 'drag');
} else if (posFinal - posInitial > threshold) {
  shiftSlide(-1, 'drag');
} else {
  items.style.left = (posInitial) + "px";
}

document.onmouseup = null;
document.onmousemove = null;
}

function shiftSlide(dir, action) {
items.classList.add('shifting');

if (allowShift) {
  if (!action) { posInitial = items.offsetLeft; }

  if (dir == 1) {
    items.style.left = (posInitial - slideSize) + "px";
    index++;      
  } else if (dir == -1) {
    items.style.left = (posInitial + slideSize) + "px";
    index--;      
  }
};

allowShift = false;
}

function checkIndex (){
items.classList.remove('shifting');

if (index == -1) {
  items.style.left = -(slidesLength * slideSize) + "px";
  index = slidesLength - 1;
}

if (index == slidesLength) {
  items.style.left = -(1 * slideSize) + "px";
  index = 0;
}

allowShift = true;
}
}




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

function reportaEvento(){

    let person = prompt("Por qual motivo você deseja reportar este evento?");

    if (!(person == null) || !(person == "")) {
     
      alert('O Evento foi reportado! Ele será revisado pelos moderadores em breve');
      document.location = 'reporta_email.php?text='+person;
    }
    
  
}

function reportaArtista(){

  let person = prompt("Por qual motivo você deseja reportar este artista?");

  if (!(person == null) || !(person == "")) {
   
    alert('O Artista foi reportado! Ele será revisado pelos moderadores em breve');
    document.location = 'reporta_artista.php?text='+person;
  }


}

