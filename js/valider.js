var form = document.getElementById('ajouter_denivele');

/************************************************
 * fonction pour afficher les érreurs
 ************************************************/
function producePrompt(message, promptLocation, color){
    if(!color) color='darkred';
    document.getElementById(promptLocation).innerHTML = message;
    document.getElementById(promptLocation).style.color = color;
}


/************************************************
 * fonction pour valider le champ de distance
 ************************************************/
function valide_distance(){
    var distance = document.getElementById('distance').value;
    if(distance.length == 0){
        producePrompt("le champ est obligatoire", "erreur_distance");
        return false;
    }
    if(!distance.match(/\d+/g)){
        producePrompt("la distance doit être en nombre entier", "erreur_distance");
        return false;
    }
    if(distance <0 || distance > 10000){
        producePrompt("la distance d'une denivelé est entre 1 et 10000", "erreur_distance");
        return false;
    }
    producePrompt("", "erreur_distance");
    return true;
}


/************************************************
 * fonction pour valider le champ de durée
 ************************************************/
function valide_duree(){
    var duree = document.getElementById('duree').value;
    if(duree.length == 0){
        producePrompt("le champ est obligatoire", "erreur_duree");
        return false;
    }
    if(!duree.match(/\d{1,2}h\d{2}/g)){
        producePrompt("la duree d'une randonnée doit être suivre le format 00h00", "erreur_duree");
        return false;
    }
    producePrompt("", "erreur_duree");
    return true;
}


/************************************************
 * fonction pour valider le champ de dénivelée
 ************************************************/
function valide_denivele(){
    var denivele = document.getElementById('denivele').value;
    if(denivele.length == 0){
        producePrompt("le champ est obligatoire", "erreur_denivele");
        return false;
    }
    if(!denivele.match(/\d+/g)){
        producePrompt("le denivelé doit être en nombre entier", "erreur_denivele");
        return false;
    }
    if(denivele <0 || denivele > 10000){
        producePrompt("veuillez entrer un nombre entre 1 et 10000", "erreur_denivele");
        return false;
    }
    producePrompt("", "erreur_denivele");
    return true;
}


/************************************************
 * fonction pour valider le champ de région
 ************************************************/
function valid_region(){
    var region = document.getElementById('region').value;
    if(environnement.length == 0){
        producePrompt("veuillez séléctionner une région", "erreur_region");
        return false;
    }
    producePrompt("", "erreur_region");
    return true;
}


/************************************************
 * fonction pour vérifier si le camps de l'environnement est vide
 ************************************************/
function valid_environnement(){
    var environnement = document.getElementById('environnement').value;
    if(environnement.length == 0){
        producePrompt("veuillez séléctionner l'environnement", "erreur_environnement");
        return false;
    }
    producePrompt("", "erreur_environnement");
    return true;
}


/************************************************
 * fonction pour vérifier si le camps de difficulté est vide
 ************************************************/
function valid_difficulte(){
    var difficulte = document.getElementById('difficulte').value;
    if(difficulte.length == 0){
        producePrompt("veuillez séléctionner le moyen de difficulté", "erreur_difficulte");
        return false;
    }
    producePrompt("", "erreur_difficulte");
    return true;
}


/************************************************
 * fonction pour vérifier si les champs sont valides
 ************************************************/
function valider_la_forme(){
    if(!valide_distance() || !valide_duree() || !valide_denivele() || !valid_region()
        || !valid_environnement()|| !valid_difficulte())
        return false;
    else
        return true;
}