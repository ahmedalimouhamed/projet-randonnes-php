<?php

require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."init.php");
require_once(DB."sql_fonctions.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $resultat = consulter("randonnees", null, null, $id);
    //verifier que l'élément à supprimé est il existe dans la base de données avant le supprimé
    if($resultat->num_rows > 0){
        try{
            if(supprimer("randonnees", $id)){
                $_SESSION['success'] = "<h2>les donnees sont supprier avec succés</h2>";
                header("Location: ".ADMINISTRATION_PAGE.'randonnees.php#randonnees_message');
            }else{
                throw new Exception("erreur de modification");
            }
        }catch(Exception $e){
            $_SESSION['erreur'] = "<h2>erreur de suppression : ".$e->getMessage()."</h2>";
            header("Location: ".ADMINISTRATION_PAGE.'randonnees.php#randonnees_message');
        }
    }
}