document.addEventListener("DOMContentLoaded", function() {
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
    }, 3000);
});
