/************************************************
 * fonction pour masquer un élement
 ************************************************/
function hide(element){
    element.style.display = "none";
}


/************************************************
 * fonction pour vérifier si l'élément est masqué
 ************************************************/
function is_hided(element){
    if (window.getComputedStyle(element).display === "none") {
        console.log("yesss");
        return true;
    }
    return false;
}


/************************************************
 * fonction pour afficher un élément
 ************************************************/
function show(element){
    element.style.display = "inline-block";
}

arr_fermer = document.querySelectorAll('.fermer_message_err_scc');


/************************************************
 * masquer l'élément qui contient la bouton de fermeture s'elle est cliquée
 ************************************************/
arr_fermer.forEach(function(element){
    element.addEventListener('click', function(){
        console.log('clicked');
        element.parentNode.parentNode.removeChild(element.parentNode);
    });
});



/************************************************
 * fonction pour masquer la forme de modification de l'image randonnée
 ************************************************/
function check_if_clicked(element){
    element.addEventListener("click", function(){
        var modifier_image = document.getElementById("modifier_image");
        if(is_hided(modifier_image)){
            show(modifier_image);
            var fermer = document.getElementById('fermer');
            fermer.addEventListener('click', function(e){
                hide(modifier_image);
            });
        }

    });
}

var element = document.querySelector(".boutton");

check_if_clicked(element);







