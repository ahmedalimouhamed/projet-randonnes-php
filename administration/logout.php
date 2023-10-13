<?php
    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."init.php");
    if(!logged_in()){
        header("Location: ".NOM_HOST."/index.php");
    }

    session_unset();
    session_destroy();
    header("Location: ".ADMINISTRATION_PAGE."/randonnees.php");