let nav = document.querySelector('nav')

const navbar = document.querySelector('.nav-fixed');
window.onscroll = () => {
    if (window.scrollY > 1) {
        navbar.classList.add('nav-active');
    } else {
        navbar.classList.remove('nav-active');
    }
};
setTimeout(function () {
    bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert")).close();
  }, 3000);
