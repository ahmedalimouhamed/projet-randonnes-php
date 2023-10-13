<?php

require_once("template".DIRECTORY_SEPARATOR."header.php");
require_once("db" . DS . "sql_fonctions.php");


if(isset($_GET['id'])){
    $id = securiser_input($_GET['id']);

    $from_arr = [
        'randonnees',
        'INNER JOIN regions ON regions.id = randonnees.id_region',
        'INNER JOIN environnement ON environnement.id = randonnees.id_environnement',
        'INNER JOIN difficultes ON difficultes.id = randonnees.id_difficulte'
    ];

    $resultats = consulter($from_arr,null, null, $id);

    if($resultats && mysqli_num_rows($resultats) > 0){
        while($row = $resultats->fetch_assoc()){
            ?>
            <div class="infos_randonnee">
                <a name='randonnee'></a>
                <h1 class="titre_h1 color_h1">randonnée avec l'id <?php echo (isset($row['id_randonnes'])) ? $row['id_randonnes'] : ''?></h1>
                <ul class="">
                    <li class="clearfix  image_info_randonnee">
                        <div class="image_randonnee">
                            <img src="<?php echo (isset($row['image'])) ? $row['image'] : '' ?>" width="600"/>
                        </div>
                    </li>
                    <li class="clearfix">
                        <h3 class="label_randonnee">région</h3>
                        <p class="info_randonnee"><?php echo (isset($row['region'])) ? $row['region'] : '' ?></p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="clearfix">
                        <h3 class="label_randonnee">la distance</h3>
                        <p class='info_randonnee'>
                            <?php echo (isset($row['distance'])) ? $row['distance']." Kilométres" : '' ?>
                        </p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="clearfix">
                        <h3 class="label_randonnee">la durée</h3>
                        <p class='info_randonnee'>
                            <?php echo (isset($row['duree'])) ? str_replace('.', 'h',$row['duree']) : '' ?>
                        </p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="clearfix">
                        <h3 class="label_randonnee">la dénivelée</h3>
                        <p class='info_randonnee'>
                            <?php echo (isset($row['denivele'])) ? $row['denivele']." métres" : '' ?>
                        </p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="clearfix">
                        <h3 class="label_randonnee">l'environnement</h3>
                        <p class='info_randonnee'>
                            <?php echo (isset($row['environnement'])) ? $row['environnement'] : '' ?>
                        </p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="clearfix">
                        <h3 class="label_randonnee">niveau de difficultée</h3>
                        <p class='info_randonnee'>
                            <?php echo (isset($row['difficulte'])) ? $row['difficulte'] : '' ?>
                        </p>
                    </li>
                    <hr class="separator_qui_somme_nous_person1_person2"/>
                    <li class="li_description clearfix">
                        <h3 class="label_randonnee description_randonnee">déscription en quelques ligne</h3>
                        <p class='info_randonnee description_randonnee_p'>
                            <?php echo (isset($row['description'])) ? $row['description'] : '' ?>
                        </p>
                    </li>

                </ul>

            </div>


            <?php

        }
    }

}

require_once("template".DS."footer.php");
?>
