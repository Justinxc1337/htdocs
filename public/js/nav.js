document.addEventListener("DOMContentLoaded", function() {
    var x = document.getElementById("myLinks");
    
    x.style.display = "none";
});

function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

// Bruges til mobil version af menu, så den kan foldes ud og ind.