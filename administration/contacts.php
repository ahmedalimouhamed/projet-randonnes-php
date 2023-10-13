<?php
require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");
require_once(APP_LOCATION.DS."pagination.php");


if(!logged_in()){
    header("Location: ".NOM_HOST."index.php");
}


/************************************************
 * affichege des messages d'érreur ou de succession si ils sont existe
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


/************************************************
 * fonction pour afficher le tableau
 ************************************************/
function afficher_data($resultats, $type){
    global $pagination;
    global $sql;
    
    
    echo "<a name='table'></a>
        <h1 class='titre_h1 color_h1'>liste des contacts</h1>";
    ?>

    <section class='section_table'>
        <div class='inner_container'>


        <?php
            
            if(isset($resultats) && $resultats->num_rows > 0){
                echo "
              <table class='table_randonnees clearfix'>
        <tr class='row_header'>";?>
                <th style='width:90px'>Nom</th>
                <th style='width:90px'>Prénom</th>
                <th style='width:100px'>activité</th>
                <th style='width:90px'>fonction</th>
                <th style=''>Adresse</th>
                <th style='width:90px'>Tél</th>
                <th style='width:100px'>Objet</th>
                <th style='width:80px'>control</th>
                <?php echo "</tr>";


                while($row = $resultats->fetch_assoc()){
                    ?>

                    <tr class='row_data'>
                        <td><?php echo (isset($row['nom'])) ? $row['nom'] : ''?></td>
                        <td><?php echo (isset($row['prénom'])) ? $row['prénom'] : ''?></td>
                        <td><?php echo (isset($row['activite'])) ? $row['activite']: ''?></td>
                        <td><?php echo (isset($row['fonction'])) ? $row['fonction']: ''?></td>
                        <td><?php echo (isset($row['adresse'])) ? $row['adresse']: ''?></td>
                        <td><?php echo (isset($row['tel'])) ? $row['tel']: ''?></td>
                        <td><?php echo (isset($row['objet'])) ? $row['objet']: ''?></td>
                        <td>
                            <ul class="control_table">
                                <li class="li_control_1"><a <?php echo "href=".ADMINISTRATION_PAGE."contact.php?id=".$row['id']."#contact"?>></a></li>
                                <li class="li_control_3"><a <?php echo "href=".ADMINISTRATION_PAGE."supprimer_contact.php?id="
                                        .$row['id']?>
                                        onclick="if(!confirm('est ce que vous êtes ce contact de la liste')) return false"></a></li>
                            </ul>
                        </td>
                    </tr>
                    <?php
                }

                echo "</table>";
            }else{
                if($type == 2){
                    $erreur = "<p>on ne trouve aucune resultat pour votre recherche</p>
                <a class='bouton' href='randonnees.php#table'>afficher la liste des contacts</a>";
                }else{
                    $erreur = "<p> la liste est vide</p>";
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

$from_arr = "contact_us";

$wheres = null;


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




$pagination = pagination();
$resultats = consulter($from_arr, get_offset(), $total_records_per_page, null, 'id desc');

afficher_data($resultats, 1);


require_once(APP_LOCATION.DS."template".DS."footer.php");
?>
