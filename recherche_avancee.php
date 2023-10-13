<?php

require_once("template".DIRECTORY_SEPARATOR."header.php");
require_once("db" . DS . "sql_fonctions.php");


//créer une session pour rehcherche avancée à partir de la form
if(isset($_POST['submit'])){
    $_SESSION['recherche_avancee'] = [];
    if(isset($_POST['region']) && !empty($_POST['region']))
        $_SESSION['recherche_avancee']['region'] = $_POST['region'];

    if(isset($_POST['environnement']) && !empty($_POST['environnement']))
        $_SESSION['recherche_avancee']['environnement'] = $_POST['environnement'];

    if(isset($_POST['distance_min']) && !empty($_POST['distance_min']))
        $_SESSION['recherche_avancee']['distance_min'] = $_POST['distance_min'];

    if(isset($_POST['distance_max']) && !empty($_POST['distance_max']))
        $_SESSION['recherche_avancee']['distance_max'] = $_POST['distance_max'];

    if(isset($_POST['duree_min']) && !empty($_POST['duree_min']))
        $_SESSION['recherche_avancee']['duree_min'] = str_replace('h', '.', $_POST['duree_min']);

    if(isset($_POST['duree_max']) && !empty($_POST['duree_max']))
        $_SESSION['recherche_avancee']['duree_max'] = str_replace('h', '.', $_POST['duree_max']);

    if(isset($_POST['denivelee_min']) && !empty($_POST['denivelee_min']))
        $_SESSION['recherche_avancee']['denivelee_min'] = $_POST['denivelee_min'];

    if(isset($_POST['denivelee_max']) && !empty($_POST['denivelee_max']))
        $_SESSION['recherche_avancee']['denivelee_max'] = $_POST['denivelee_max'];

    $_SESSION['recherche_avancee']['time_recherche'] = strtotime("now");

    header("Location: randonnees.php?recherche_avancee=".$_SESSION['recherche_avancee']['time_recherche']."#table");

}
?>
    <section class="section_form_administration">
        <div class="inner_container">
            <a name='recherche_avancee'></a>
            <h1 class="titre_h1 color_h1">recherche avancée</h1>
            <form class="recherche_avancee clearfix" method="post" action="">
                <div>
                    <label>région: </label><br/>
                    <input type="text" name="region" placeholder="recherche par région">
                </div>
                <div>
                    <label>environnement: </label><br/>
                    <input type="text" name="environnement" placeholder="recherche par environnement">
                </div>
                <div class="spared clearfix">
                    <label>distance entre: </label><br/>
                    <input type="text" name="distance_min" placeholder="valeur minimale">

                    <input type="text" name="distance_max" placeholder="valeur maximale">
                </div>

                <div class="spared clearfix">
                    <label>durée entre: </label><br/>
                    <input type="text" name="duree_min" placeholder="valeur minimale">

                    <input type="text" name="duree_max" placeholder="valeur maximale">
                </div>
                <div class="spared clearfix">
                    <label>denivelée entre: </label><br/>
                    <input type="text" name="denivelee_min" placeholder="valeur minimale">

                    <input type="text" name="denivelee_max" placeholder="valeur maximale">
                </div>

                <div class="clearfix">
                    <input type="submit" name="submit">
                </div>
            </form>
        </div>
    </section>
<?php
require_once("template".DS."footer.php");
?>