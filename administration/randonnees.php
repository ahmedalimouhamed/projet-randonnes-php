<?php
require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");
require_once(APP_LOCATION.DS."pagination.php");


if(!logged_in()){
    header("Location: ".NOM_HOST."index.php");
}


/************************************************
 * affichage des messages d'érreur ou de succession si ils sont existe
 ************************************************/
if(isset($_SESSION['success'])){
    echo "<a name='randonnees_message'></a>
    <div class ='success_message'>".$_SESSION['success']."<div class='fermer_message_err_scc'></div></div>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['erreur'])){
    echo "<a name='randonnees_message'></a>
    <div class='erreur_message'>".$_SESSION['erreur']."<div class='fermer_message_err_scc'></div></div>";
    unset($_SESSION['erreur']);
}


$from_arr = [
    'randonnees',
    'INNER JOIN regions ON regions.id = randonnees.id_region',
    'INNER JOIN environnement ON environnement.id = randonnees.id_environnement',
    'INNER JOIN difficultes ON difficultes.id = randonnees.id_difficulte'
];

$wheres = [
    'randonnees.id_region' => 'regions.id',
    'randonnees.id_environnement' => 'environnement.id',
    'randonnees.id_difficulte' => 'difficultes.id'
];


if(!isset($_GET['resultat_recherche'])){
    unset($_SESSION['recherche']);
}


if(!isset($_GET['recherche_avancee'])){
    unset($_SESSION['recherche_avancee']);
}


/************************************************
 * fonction pour trier les données avec un ordre détérminé
 ************************************************/
function order_by(){
    if(isset($_GET['order']) && isset($_GET['ascDesc']))
        return $_GET['order'].' '.$_GET['ascDesc'];
    return null;
}


/************************************************
 * fonction pour générer l'url àpartir de l'entête du table
 ************************************************/
function creer_href_hr_table($valeur){
    if(isset($_GET['ascDesc']))
        $ascDesc = $_GET['ascDesc'];
    else
        $ascDesc = 'ASC';

    if(isset($_GET['resultat_recherche'])){
        if(isset($_GET['order']) && $_GET['order'] == $valeur && $ascDesc == 'ASC')
            echo "href=randonnees.php?resultat_recherche=".$_GET['resultat_recherche']
                ."&order=".$valeur."&ascDesc=DESC#table";
        else
            echo "href=randonnees.php?resultat_recherche=".$_GET['resultat_recherche']
                ."&order=".$valeur."&ascDesc=ASC#table";
    }

    else if(isset($_GET['recherche_avancee'])){
        if(isset($_GET['order']) && $_GET['order'] == $valeur && $ascDesc == 'ASC')
            echo "href=randonnees.php?recherche_avancee=".$_GET['recherche_avancee']
                ."&order=".$valeur."&ascDesc=DESC#table";
        else
            echo "href=randonnees.php?recherche_avancee=".$_GET['recherche_avancee']
                ."&order=".$valeur."&ascDesc=ASC#table";
    }

    else{
        if(isset($_GET['order']) && $_GET['order'] == $valeur && $ascDesc == 'ASC')
            echo "href=randonnees.php?order=".$valeur."&ascDesc=DESC#table";
        else
            echo "href=randonnees.php?order=".$valeur."&ascDesc=ASC#table";
    }
}



/************************************************
 * fonction pour générer l'url pour pagination
 ************************************************/
function creer_href_pagination($valeur){
    if(isset($_GET['ascDesc']))
        $ascDesc = $_GET['ascDesc'];
    else
        $ascDesc = 'ASC';
    if (isset($_GET['resultat_recherche'])){
        echo "href=randonnees.php?resultat_recherche=".$_GET['resultat_recherche'] ."&page_no=".$valeur."#table";
    }

    else if(isset($_GET['recherche_avancee']))
        echo "href=randonnees.php?recherche_avancee=".$_GET['recherche_avancee'] ."&page_no=".$valeur."#table";
    else if(isset($_GET['order']) && $ascDesc == 'DESC')
        echo "href=randonnees.php?order=".$_GET['order']."&ascDesc=ASC&page_no=".$valeur."#table";
    else if(isset($_GET['order']) && $ascDesc == 'ASC')
        echo "href=randonnees.php?order=".$_GET['order']."&ascDesc=DESC&page_no=".$valeur."#table";
    else
        echo "href=randonnees.php?page_no=".$valeur."#table";
}



if(isset($_POST['submit'])){
    if(!empty($_POST['normal_recherche'])){
        $_SESSION['recherche']['time_recherche'] = strtotime("now");
        $_SESSION['recherche']['valeur_a_chercher'] = securiser_input($_POST['normal_recherche']);
        header("Location:randonnees.php?resultat_recherche=".$_SESSION['recherche']['time_recherche']."#table");
    }

}


/************************************************
 * fonction pour afficher le tableau
 ************************************************/
function afficher_data($resultats, $type){
    global $pagination;
    global $sql;
    if(isset ($_SESSION['recherche']['valeur_a_chercher']))
        $valeur_a_chercher = $_SESSION['recherche']['valeur_a_chercher'];
    else
        $valeur_a_chercher = '';
    echo "<a name='table'></a>
        <h1 class='titre_h1 color_h1'>liste des randonnées</h1>";
    ?>

    <section class='section_table'>
        <div class='inner_container'>


            <?php
            echo "
            <div class='search_bar clearfix'>
                <form method='post' action='' class='recherche_form clearfix'>";
            if($type == 2){
                echo "
                        <div class=\"message_recherche\">
                            <a href=\"randonnees.php#table\">consulter tout les randonnés</a>
                        </div>
                    ";
            }


            echo"
                <input type='text' name='normal_recherche' placeholder='rechercher' value = $valeur_a_chercher>
                <input type='submit' name='submit' value=''>

                </form>
            <div class='recherche_avance'>
               <p><a href='recherche_avancee.php#recherche_avancee'>recherche avancé</a></p>
            </div>


            </div>";

            echo "
              <hr class='separator_randonnees'/>

        ";
            if(isset($resultats) && $resultats->num_rows > 0){
                echo "<div class='boutton right ajout_btn'>
                 <a href='operations/ajouter.php#ajouter'>ajouter une rndonnée</a>
              </div>
              <table class='table_randonnees clearfix'>
        <tr class='row_header'>";?>
                <th style='width:60px'>
                    <a <?php creer_href_hr_table('id_randonnes');?>>id</a>
                </th>
                <th style='width:90px'>
                    <a <?php creer_href_hr_table('distance');?>>distance</a>
                </th>
                <th style='width:100px'>
                    <a <?php creer_href_hr_table('denivele');?>>denivelée</a>
                </th>
                <th style='width:90px'>
                    <a <?php creer_href_hr_table('duree');?>>duree</a>
                </th>
                <th style=''>
                    <a <?php creer_href_hr_table('region');?>>region</a>
                </th>
                <th style='width:160px'>
                    <a <?php creer_href_hr_table('environnement');?>>environnement</a>
                </th>
                <th style='width:100px'>
                    <a <?php creer_href_hr_table('difficulte');?>>difficulté</a>
                </th>
                <th style='width:80px'>control</th>
                <?php echo "</tr>";


                while($row = $resultats->fetch_assoc()){
                    ?>

                    <tr class='row_data'>
                        <td><?php echo (isset($row['id_randonnes'])) ? $row['id_randonnes'] : ''?></td>
                        <td><?php echo (isset($row['distance'])) ? $row['distance']." Km" : ''?></td>
                        <td><?php echo (isset($row['denivele'])) ? $row['denivele']." m" : ''?></td>
                        <td><?php echo (isset($row['duree'])) ? str_replace('.', 'h',$row['duree']) : ''?></td>
                        <td><?php echo (isset($row['region'])) ? $row['region'] : ''?></td>
                        <td><?php echo (isset($row['environnement'])) ? $row['environnement'] : ''?></td>
                        <td><?php echo (isset($row['difficulte'])) ? $row['difficulte'] : ''?></td>
                        <td>
                            <ul class="control_table">
                                <li class="li_control_1"><a <?php echo "href=".ADMINISTRATION_PAGE."randonnee.php?id=".$row['id_randonnes']."#randonnee"?>></a></li>
                                <li class="li_control_2"><a <?php echo "href=".OPERATION_ADMINISTRATION_PAGE."modifier.php?id="
                                        .$row['id_randonnes']."#modifier"?>></a></li>
                                <li class="li_control_3"><a <?php echo "href=".OPERATION_ADMINISTRATION_PAGE."supprimer.php?id="
                                        .$row['id_randonnes']?>
                                        onclick="if(!confirm('est ce que vous êtes cet randonnee de la liste')) return false"></a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php
                }

                echo "</table>";
            }else{
                if($type == 2){
                    $erreur = "<p>on ne trouve aucune resultat pour votre recherche</p>
                <a class='bouton' href='randonnees.php#table'>afficher la liste des randonnés</a>";
                }else{
                    $erreur = "<p> la liste est vide</p>
                <a class='bouton'  href= ".OPERATION_ADMINISTRATION_PAGE."ajouter.php#ajouter>ajouter une
                randonnée</a>";
                }
                ?>
                <div class="erreur_randonnees">
                    <div></div>
                    <?php echo $erreur; ?>
                </div>
                <?php
            }

            ?>
        </div>
    </section>
    <?php

    if($pagination['total_no_of_pages'] > 1){
        ?>
        <ul class="navig">
            <?php if($pagination['page_no'] > 1){
                ?>
                <li class='rect first_page'>
                    <a <?php creer_href_pagination(1)?>>First Page</a>
                </li>
                <?php
            } ?>

            <li <?php if($pagination['page_no'] <= 1){ echo "class='rect previous disabled'"; }
            if($pagination['page_no'] > 1) {echo "class='rect next'";}?>>
                <a <?php creer_href_pagination($pagination['previous_page']);?>>Previous</a>
            </li>
            <?php

            if ($pagination['total_no_of_pages'] <= 10){
                for ($counter = 1; $counter <= $pagination['total_no_of_pages']; $counter++){
                    if ($counter == $pagination['page_no']) {
                        echo "<li class='active'><a>$counter</a></li>";
                    }else{
                        ?>
                        <li>
                            <a <?php creer_href_pagination($counter);?>><?php echo $counter?></a>

                        </li>
                        <?php
                    }
                }
            }
            ?>

            <li <?php if($pagination['page_no'] >= $pagination['total_no_of_pages']){
                echo "class='rect next disabled'";
            }if($pagination['page_no'] < $pagination['total_no_of_pages']) {
                echo "class='rect next'";
            } ?>>
                <a <?php creer_href_pagination($pagination['next_page']);?>>Next</a>
            </li>

            <?php if($pagination['page_no'] < $pagination['total_no_of_pages']){
                ?><li class='rect last_page'>
                <a <?php
                creer_href_pagination($pagination['total_no_of_pages']);?>>Last &rsaquo;&rsaquo;</a></li>
                <?php
            } ?>
        </ul>
        <?php
    }
}





if(!(isset($_GET['resultat_recherche'])) && !(isset($_GET['recherche_avancee']))){
    $pagination = pagination();
    $resultats = consulter($from_arr, get_offset(), $total_records_per_page, null, order_by());

    afficher_data($resultats, 1);


}else if(isset($_GET['resultat_recherche'])){
    if(isset($_SESSION['recherche']['valeur_a_chercher'])){
        $valeur_a_chercher = $_SESSION['recherche']['valeur_a_chercher'];
        $wheres_normal_recherche = [
            "regions.region LIKE '%".$valeur_a_chercher."%'",
            "environnement.environnement LIKE '%".$valeur_a_chercher."%'",
            "difficultes.difficulte LIKE '%".$valeur_a_chercher."%'",
        ];
        $resultat_recherche = recherche($from_arr, get_offset(), $total_records_per_page, $wheres_normal_recherche, 'simple', order_by
        ());

    }
}else if(isset($_GET['recherche_avancee'])){
    $wheres_avancee_recherche = [];
    if(isset($_SESSION['recherche_avancee']['region']))
        $wheres_avancee_recherche[] = " region LIKE '%". $_SESSION['recherche_avancee']['region']."%'";

    if(isset($_SESSION['recherche_avancee']['environnement']))
        $wheres_avancee_recherche[] = " environnement LIKE '%". $_SESSION['recherche_avancee']['environnement']."%'";

    if(isset($_SESSION['recherche_avancee']['distance_min']))
        $wheres_avancee_recherche[] = " distance >= " . $_SESSION['recherche_avancee']['distance_min'];

    if(isset($_SESSION['recherche_avancee']['distance_max']))
        $wheres_avancee_recherche[] = " distance <= " . $_SESSION['recherche_avancee']['distance_max'];

    if(isset($_SESSION['recherche_avancee']['duree_min']))
        $wheres_avancee_recherche[] = " duree >= " . $_SESSION['recherche_avancee']['duree_min'];

    if(isset($_SESSION['recherche_avancee']['duree_max']))
        $wheres_avancee_recherche[] = " duree <= " . $_SESSION['recherche_avancee']['duree_max'];

    if(isset($_SESSION['recherche_avancee']['denivelee_min']))
        $wheres_avancee_recherche[] = " denivele >= " . $_SESSION['recherche_avancee']['denivelee_min'];

    if(isset($_SESSION['recherche_avancee']['denivelee_max']))
        $wheres_avancee_recherche[] = " denivele <= " . $_SESSION['recherche_avancee']['denivelee_max'];

    if(!empty($wheres_avancee_recherche))
        $resultat_recherche = recherche($from_arr, get_offset(), $total_records_per_page, $wheres_avancee_recherche, 'avancee', order_by());
    else
        header("Location: randonnees.php#table");

}




if((isset($_GET['resultat_recherche'])) || (isset($_GET['recherche_avancee']))){
    $message = "resultat de recherche";
    $message_barre_recherche = "consulter tout les randonnés";
    afficher_data($resultat_recherche, 2);
}

require_once(APP_LOCATION.DS."template".DS."footer.php");
?>
