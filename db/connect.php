<?php

/************************************************
 * fonction pour etablir la connexion avec la base des donnés
 ************************************************/
    try{
        $mysqli = new mysqli(HOST_DB, NOM_UTILISATEUR, MOT_DE_PASSE, NOM_DB);
    }catch(Exception $e){
        $error = $e->getMessage();
        echo $error;
    }
