<?php

    require_once("config.php");
    //require_once("pagination.php");

/************************************************
 * demarrer la session
 ************************************************/
    ob_start();
    session_start();

/************************************************
 * fonction pour securiser les inputs
 ************************************************/
    function securiser_input($input){
        return htmlentities($input, ENT_QUOTES, "UTF-8");
    }


/************************************************
 * fonction pour vérifier si l'utilisateur est connecté
 ************************************************/
    function logged_in(){
        return isset($_SESSION['utilisateur']);
    }


/************************************************
 * fonction pour vérifiet si letableau est associative
 ************************************************/
    function associative_array(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }


/************************************************
 * fonction pour détérminier le menu actif
 ************************************************/
    function page_activee(){
        $serv =  $_SERVER['PHP_SELF'];
       $exploded = explode('/', $serv);
        return end($exploded);
    }


?>
