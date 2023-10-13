<?php
    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");

    if(!logged_in()){
        header("Location: ".NOM_HOST."index.php");
    }

    if(isset($_GET['id'])){
        $id = securiser_input($_GET['id']);
    
        $from_arr = 'contact_us';
    
        $resultats = consulter($from_arr,null, null, $id);

        while($row = $resultats->fetch_assoc()){
            ?>
                <div class="infos_randonnee">
                    <a name='randonnee'></a>
                    <h1 class="titre_h1 color_h1">Contact avec l'id <?php echo (isset($row['id'])) ? $row['id'] : ''?></h1>
                    <ul class="">
                        
                        <li class="clearfix">
                            <h3 class="label_randonnee">Nom</h3>
                            <p class="info_randonnee"><?php echo (isset($row['nom'])) ? $row['nom'] : '' ?></p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Préom</h3>
                            <p class="info_randonnee"><?php echo (isset($row['prenom'])) ? $row['prenom'] : '' ?></p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Activité</h3>
                            <p class="info_randonnee"><?php echo (isset($row['activite'])) ? $row['activite'] : '' ?></p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Adresse</h3>
                            <p class='info_randonnee'>
                                <?php echo (isset($row['adresse'])) ? $row['adresse'] : '' ?>
                            </p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Ville</h3>
                            <p class='info_randonnee'>
                                <?php echo (isset($row['ville'])) ? $row['ville'] : '' ?>
                            </p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Tél</h3>
                            <p class='info_randonnee'>
                                <?php echo (isset($row['tel'])) ? $row['tel'] : '' ?>
                            </p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="clearfix">
                            <h3 class="label_randonnee">Objet</h3>
                            <p class='info_randonnee'>
                                <?php echo (isset($row['objet'])) ? $row['objet'] : '' ?>
                            </p>
                        </li>
                        <hr class="separator_qui_somme_nous_person1_person2"/>
                        <li class="li_description clearfix">
                            <h3 class="label_randonnee description_randonnee">Méssage</h3>
                            <p class='info_randonnee description_randonnee_p'>
                                <?php echo (isset($row['message'])) ? $row['message'] : '' ?>
                            </p>
                        </li>
                        <li class="clearfix">
                            <button class="boutton randonnee_supprimer" style="margin-top: 30px"><a href="<?php echo ADMINISTRATION_PAGE
                                    .'/supprimer_contact.php?id='.$id."#supprimer" ?>">Supprimer le contact</a></button>
                        </li>
                    </ul>
    
                </div>
    
    
        <?php
    
            }
    }

    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."footer.php");
?>