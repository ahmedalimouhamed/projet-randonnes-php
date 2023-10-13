<?php
    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."init.php");
    require_once(DB."sql_fonctions.php");

    if(!logged_in()){
        header("Location: ".NOM_HOST."/index.php");
    }
    header("Location: ".ADMINISTRATION_PAGE."randonnees.php");