
function jackets(){
    document.getElementById("jackets").style.display= "block";
    document.getElementById("shoes").style.display= "none";
    document.getElementById("hoodies").style.display= "none";
    document.getElementById("trousers").style.display= "none";
    document.getElementById("shorts").style.display= "none";   
}
function shoes(){
    document.getElementById("jackets").style.display= "none";
    document.getElementById("shoes").style.display= "block";
    document.getElementById("hoodies").style.display= "none";
    document.getElementById("trousers").style.display= "none";
    document.getElementById("shorts").style.display= "none";   
}
function hoodies(){
    document.getElementById("jackets").style.display= "none";
    document.getElementById("shoes").style.display= "none";
    document.getElementById("hoodies").style.display= "block";
    document.getElementById("trousers").style.display= "none";
    document.getElementById("shorts").style.display= "none";   
}
function trousers(){
    document.getElementById("jackets").style.display= "none";
    document.getElementById("shoes").style.display= "none";
    document.getElementById("hoodies").style.display= "none";
    document.getElementById("trousers").style.display= "block";
    document.getElementById("shorts").style.display= "none";   
}
function shorts(){
    document.getElementById("jackets").style.display= "none";
    document.getElementById("shoes").style.display= "none";
    document.getElementById("hoodies").style.display= "none";
    document.getElementById("trousers").style.display= "none";
    document.getElementById("shorts").style.display= "block";  
}

let check= true;
function swap(){/*χρησιμοποιείται στη σελίδα products για να αλλάζει την φωτογραφία με το βίντεο*/
    const img = document.getElementById("p1");
    const video = document.getElementById("p2");
    const previewText = document.getElementById("prev");

    if (check) {
        img.style.display = "none";
        video.style.display = "block";
        previewText.innerHTML = "Δες τη φώτο";
        check = false;
    } else {
        img.style.display = "block";
        video.style.display = "none";
        previewText.innerHTML = "Δες το βίντεο";
        check = true;
    }
}