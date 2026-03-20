var mybutton = document.getElementById("back-to-top");

function scrollFunction() {
    100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
}

function topFunction() {
    document.body.scrollTop = 0,
        document.documentElement.scrollTop = 0
}
mybutton && (window.onscroll = function() {
    scrollFunction()
});