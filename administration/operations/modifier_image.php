<?php

require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."init.php");
require_once(DB."sql_fonctions.php");

if(!logged_in()){
    header("Location: ".NOM_HOST."index.php");
}

if(isset($_GET['id'])){
    $id = securiser_input($_GET['id']);

    //$resultats = simple_consulter($nom_tables, $nom_champs, $wheres);

    if(isset($_POST['submit']) && isset($_FILES)){
        $nom_image = basename(strtotime("now").'.' .pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image_dest = IMAGES."images_uploader".DS.$nom_image;
        $image = mysqli_real_escape_string($mysqli, URL_UPLOADED_IMAGES.$nom_image);


        $nom_table = 'randonnees';
        $champs_modifies = [
            'image' => $image
        ];

        if(move_uploaded_file($_FILES["image"]['tmp_name'],$image_dest))
        {
            try{
                if(modifier($nom_table, $champs_modifies, $id)) {
                    $_SESSION['success'] = "<h2>l'image a été bien modifier avec succés</h2>";
                    header("Location: " . OPERATION_ADMINISTRATION_PAGE . "modifier.php?id=$id");
                }else{
                    throw new Exception("erreur de saisi sur la table ".$nom_table);
                }
            }catch(Exception $e){
                $_SESSION['erreur'] = "<h2>erreur : ".$e->getMessage()."</h2>";
            }
        }else{
            $_SESSION['erreur'] = "<h2>problème au chargement du ficher</h2>";
            header("Location:".OPERATION_ADMINISTRATION_PAGE." modifier.php?id=".$id);
        }


    }


}

require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."footer.php");
?>