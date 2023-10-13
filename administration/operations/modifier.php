<?php

require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");

if(!logged_in()){
    header("Location: ".NOM_HOST."index.php");
}

if(isset($_SESSION['success'])){
    echo "<div class ='success_message'".$_SESSION['success']."<div class='fermer_message_err_scc'></div></div>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['erreur'])){
    echo "<div class='erreur_message'".$_SESSION['erreur']."<div class='fermer_message_err_scc'></div></div>";
    unset($_SESSION['erreur']);
}

$valeur_selection_region = consulter("regions");
$valeur_selection_environnement = consulter("environnement");
$valeur_selection_difficulte = consulter("difficultes");

if(isset($_GET['id'])){
    $id = securiser_input($_GET['id']);
    $nom_tables = ['randonnees', 'regions', 'difficultes', 'environnement'];
    $nom_champs = ['distance','duree', 'denivele', 'region', 'environnement', 'difficulte','image', 'description'];
    $wheres = [
        'randonnees.id_region' => 'regions.id',
        'randonnees.id_environnement' => 'environnement.id',
        'randonnees.id_difficulte' => 'difficultes.id',
        'randonnees.id' => $id
    ];

    $from_arr = [
        'randonnees',
        'INNER JOIN regions ON regions.id = randonnees.id_region',
        'INNER JOIN environnement ON environnement.id = randonnees.id_environnement',
        'INNER JOIN difficultes ON difficultes.id = randonnees.id_difficulte'
    ];

    $resultats = consulter($from_arr, null, null, $id);

    if(isset($_POST['submit'])){
        $distance = securiser_input($_POST['distance']);
        $duree = str_replace('h', '.', securiser_input($_POST['duree']));
        $denivele = securiser_input($_POST['denivele']);
        $region = securiser_input($_POST['region']);
        $environnement = securiser_input($_POST['environnement']);
        $difficulte = securiser_input($_POST['difficulte']);
        $description = securiser_input($_POST['description']);

        $nom_table = 'randonnees';
        $champs_modifies = [
            'distance' => $distance,
            'duree' => $duree,
            'denivele' => $denivele,
            'id_region' => $region,
            'id_environnement' => $environnement,
            'id_difficulte' => $difficulte,
            'description' => $description
        ];

        try{
            if(modifier($nom_table, $champs_modifies, $id)) {
                $_SESSION['success'] = "<h2>les champs sont modifiés avec succés</h2>";
                header("Location:" . ADMINISTRATION_PAGE . "/randonnees.php#randonnees_message");
            }else{
                throw new Exception("erreur de saisi sur la table ".$nom_table);
            }
        }catch(Exception $e){
            $_SESSION['erreur'] = "<h2>erreur: ".$e->getMessage()."</h2>";
            header("Location:" . ADMINISTRATION_PAGE . "/randonnees.php#randonnees_message");
        }
    }

    while($row = $resultats->fetch_assoc()){
        ?>
    <section class="section_form_administration">
        <div class="inner_container">
                <a name='modifier'></a>
                <h1 class="titre_h1 color_h1">modifier les donnés du randonnee</h1>
                <div class="form modifier_randonnee clearfix">
                    <div class="clearfix cotainer_img">
                        <div class="image_a_modifier clearfix">
                            <img src="<?php echo (isset($row['image'])) ? $row['image'] : '' ?>" width="400"/>
                        </div>
                        <button class="boutton bouton_modifier_image">modifier l'image</a></button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="form modifier_randonnee clearfix"
                          onsubmit="return valider_la_forme()">
                        <div>
                            <label>distance</label><br/>
                            <div class="input_div clearfix">
                                <input type="text" name="distance" placeholder="distance" id="distance"
                                       value="<?php echo (isset($row['distance'])) ? $row['distance'] : '' ?>"/>
                                <p class="input_erreur"></p>
                            </div>

                        </div>
                        <div>
                            <label>durée</label><br/>
                            <div class="input_div clearfix">
                                <input type="text" name="duree" placeholder="durée"  id="duree"
                                       value="<?php echo (isset($row['duree'])) ? str_replace('.', 'h',$row['duree']) : '' ?>"/>
                                <p class="input_erreur"></p>
                            </div>

                        </div>
                        <div>
                            <label>dénivelé</label><br/>
                            <div class="input_div clearfix">
                                <input type="text" name="denivele" placeholder="denivele" id="denivele"
                                       value="<?php echo (isset($row['denivele'])) ? $row['denivele'] : '' ?>"/>
                                <p class="input_erreur"></p>
                            </div>

                        </div>
                        <div>
                            <label>région</label><br/>
                            <div class="input_div clearfix">
                                <select name="region" class="select_form" id="region" required="required">
                                    <option>-----séléctionner une région-----</option>
                                    <?php
                                    while($inner_row = mysqli_fetch_assoc($valeur_selection_region)){
                                        ?>
                                        <option value="<?php echo $inner_row["id"] ?>" selected="<?php echo ($row['id'] == $inner_row['id'])? 'selected' : ''?>"><?php echo $inner_row["region"] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="input_erreur" id="erreur_region"></p>
                            </div>

                        </div>

                        <div>
                            <label>environnement</label><br/>
                            <div class="input_div clearfix">
                                <select name="environnement" class="select_form" required="required">
                                    <option>-----séléctionner une environnement-----</option>
                                    <?php
                                    while($inner_row = mysqli_fetch_assoc($valeur_selection_environnement)){
                                        ?>
                                        <option value="<?php echo $inner_row["id"] ?>" selected="<?php echo ($row['id'] == $inner_row['id'])? 'selected' : ''?>"><?php echo $inner_row["environnement"]?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="input_erreur" id="erreur_environnement"></p>
                            </div>
                        </div>

                        <div>
                            <label>difficulté</label><br/>
                            <div class="input_div clearfix">
                                <select name="difficulte" class="select_form" required="required">
                                    <option>-----séléctionner le niveau-----</option>
                                    <?php
                                    while($inner_row = mysqli_fetch_assoc($valeur_selection_difficulte)){
                                        ?>
                                        <option value="<?php echo $inner_row["id"] ?>" selected="<?php echo ($row['id'] == $inner_row['id'])? 'selected' : ''?>"><?php echo $inner_row["difficulte"] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="input_erreur" id="erreur_difficulte"></p>
                            </div>

                        </div>

                        <div>
                            <label>déscription</label><br/>
                            <textarea name="description" placeholder="description" required="required"><?php echo (isset
                                ($row['description']) ) ? $row['description'] : '' ?></textarea>
                            <p class="input_erreur" id="erreur_description"></p>
                        </div>

                        <div>
                            <input type="submit" name="submit" value="modifier la randonnée">
                        </div>
                    </form>

                    <form action="modifier_image.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data"
                          class="form modifier_image clearfix" id="modifier_image">
                        <button class="fermer" id="fermer">x</button>
                        <div class="inner_div clearfix">
                            <label>image</label><br/>
                            <input type="file" name="image" placeholder="image" required="" accept="image/png,
                image/jpeg" value="<?php echo (isset($row['image']) ) ? $row['image'] : '' ?>"/>
                            <div>
                                <input type="submit" name="submit" value="modifier la randonnée">
                            </div>
                        </div>


                    </form>

                </div>
        </div>
    </section>
        <?php

    }
}
require_once(APP_LOCATION.DS."template".DS."footer.php");

?>





