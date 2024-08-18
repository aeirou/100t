setTimeout(function () {
    bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
  }, 3000);

const nav = document.getElementById('nav')

window.addEventListener('scroll', function(){
  if(window.scrollY > 10){
    nav.classList.add('active')
  } else {
    nav.classList.remove('active')
  }
});