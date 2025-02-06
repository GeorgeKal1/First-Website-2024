let num1,target,input;

function getRandomNumber(min, max) {//συνάρτηση που δημιουργεί εναν τυχαίο αριθμ΄ό 
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


function startgame(){//Η συνάρτηση που ξεκινάει το παιχνίδι με τις εκπτώσεις
    target= getRandomNumber(30,70);
    document.getElementById("start").style.display= "none";
    document.getElementById("game1").style.display= "inline";
    document.getElementById("game2").style.display= "inline";
    document.getElementById("p1").innerHTML="Δώσε έναν αριθμό από 30 έως 70";
}

document.getElementById("game2").addEventListener("click" ,()=>{// συνάρτηση που κάνει έλεγχο δεδομένων και αποτελεσμάτων
    document.getElementById("game1").style.outline="none";

    input= parseInt(document.getElementById("game1").value, 10);
    if (isNaN(input)||input<30||input>70){
        document.getElementById("p2").innerHTML= "Πρέπει να δώσεις ένα αριθμό από 30 εώς 70";
        document.getElementById("game1").style.outline="1px solid red";
        return;
    }


    if (input>target){
        document.getElementById("p2").innerHTML= "Ο αριθμός είναι μικρότερος";
    }else if(input<target){
        document.getElementById("p2").innerHTML= "Ο αριθμός είναι μεγαλύτερος";
    }else{
        document.getElementById("p2").innerHTML= `Συγχαρητήρια!! Ο ${target}% κωδικός έκπτωσής σου είναι ο ${getRandomNumber(10000,99999)}`
        document.getElementById("game2").disabled = "true";
    }
});


  