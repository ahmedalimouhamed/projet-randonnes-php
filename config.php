<?php

/************************************************
 * des constants pour determiner l'url des pages du projet
 ************************************************/

    define('DS', DIRECTORY_SEPARATOR);
    define('NOM_HOST','http://'.$_SERVER['HTTP_HOST'].'/randonnees_2/');
    define('ADMINISTRATION_PAGE', NOM_HOST.'administration/');
    define('OPERATION_ADMINISTRATION_PAGE', ADMINISTRATION_PAGE.'operations/');
    define('URL_UPLOADED_IMAGES', NOM_HOST.'images/images_uploader/');
    define('JS', NOM_HOST.'js/');
    define('CSS', NOM_HOST.'styles/');


/************************************************
 * des constants pour determiner les trajets des fichiers du projet
 ************************************************/

    define('APP_LOCATION', dirname(__FILE__));
    define('JS_PATH', APP_LOCATION.DS.'js'.DS);
    define('IMAGES', APP_LOCATION.DS.'images'.DS);
    define('DB', APP_LOCATION.DS.'db'.DS);


/************************************************
 * des constants pour la base de donnés
 ************************************************/
    define('HOST_DB', 'localhost');
    define('NOM_DB', 'randonnees');
    define('NOM_UTILISATEUR', 'root');
    define('MOT_DE_PASSE', '');