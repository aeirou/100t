let navbar = document.getElementById('nav');

if (navbar) {
    window.addEventListener("scroll", function () {
        console.log("Scroll event triggered"); // Debugging line
        if (window.scrollY > 1) {
            navbar.style.backgroundColor = "blue"; // Temporary inline style for testing
        } else {
            navbar.style.backgroundColor = "transparent";
        }
    });
}

setTimeout(function () {
    let alert = bootstrap.Alert.getOrCreateInstance(document.querySelector(".alert"));
    if (alert) {
        alert.close();
    }
}, 10000);


// for the quantity button for each product
const plus = document.querySelector('.plus'),
minus = document.querySelector('.minus'),
qty = document.querySelector('.qty');

let a = 1;

// when plus button is clicked
plus.addEventListener('click', ()=>{
    a++;
    a = (a < 10) ? a : a;
    qty.value = a;
});

// when minus button is clicked
minus.addEventListener('click', ()=>{
    if (a > 1) {
        a--;
        a = (a < 10) ? a : a;
        qty.value = a;
    }    
});
