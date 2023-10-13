<?php
    require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");

    $valeur_selection_region = consulter("regions");
    $valeur_selection_environnement = consulter("environnement");
    $valeur_selection_difficulte = consulter("difficultes");

    if(isset($_POST['submit'])){
        $distance = securiser_input($_POST['distance']);
        $duree = str_replace('h', '.', securiser_input($_POST['duree']));
        $denivele = securiser_input($_POST['denivele']);
        $region = securiser_input($_POST['region']);
        $environnement = securiser_input($_POST['environnement']);
        $difficulte = securiser_input($_POST['difficulte']);
        $nom_image = basename(strtotime("now").'.' .pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $image_dest = IMAGES."images_uploader".DS.$nom_image;
        $image = mysqli_real_escape_string($mysqli, URL_UPLOADED_IMAGES.$nom_image);
        $description = securiser_input($_POST['description']);

        $nom_table = 'randonnees';
        $champs = [
            'distance' => $distance,
            'duree' => $duree,
            'denivele' => $denivele,
            'id_region' => $region,
            'id_environnement' => $environnement,
            'id_difficulte' => $difficulte,
            'image' => $image,
            'description' => $description
        ];

        //créer le dossier images_uploader s'il n'existe pas
        if(!file_exists(IMAGES."images_uploader"))
            mkdir(IMAGES."images_uploader");


        //charger l'image sur le dosser images_uploader
        if(move_uploaded_file($_FILES["image"]['tmp_name'],$image_dest))
        {
            try{
                if(ajouter($nom_table, $champs)) {
                    $_SESSION['success'] = "<h2>les champs saisis avec succés</h2>";
                    header("Location:" . ADMINISTRATION_PAGE . "/randonnees.php#randonnees_message");
                }else{
                    throw new Exception("erreur de saisi sur la table ".$nom_table);
                }
            }catch(Exception $e){
                $_SESSION['erreur'] = "<h2>erreur ".$e->getMessage()."</h2>";
                header("Location:" . ADMINISTRATION_PAGE . "/randonnees.php#randonnees_message");
            }

        }else{
            $_SESSION['erreur'] = "<h2>problème au chargement du ficher</h2>";
            header("Location:" . ADMINISTRATION_PAGE . "/randonnees.php#randonnees_message");
        }


    }

?>

<section class="section_form_administration">
    <div class="inner_container">
        <a name='ajouter'></a>
        <h1 class="titre_h1">ajouter une randonnée</h1>
        <form action="" method="post" enctype="multipart/form-data" class="form form_administration ajout_randonnees_form
clearfix" onsubmit="return valider_la_forme()" id="ajouter_denivele">
            <div>
                <label>distance</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="distance" placeholder="distance" id="distance"/>
                    <p class="input_erreur" id="erreur_distance"></p>
                </div>

            </div>
            <div>
                <label>durée</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="duree" placeholder="durée" id="duree"/>
                    <p class="input_erreur" id="erreur_duree"></p>
                </div>

            </div>
            <div>
                <label>dénivelé</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="denivele" placeholder="denivele" id='denivele'/>
                    <p class="input_erreur" id="erreur_denivele"></p>
                </div>

            </div>
            <div>
                <label>région</label><br/>
                <div class="input_div clearfix">
                    <select name="region" class="select_form" id="region" required="required">
                        <option value="">-----séléctionner une région-----</option>
                        <?php
                        while($row = mysqli_fetch_assoc($valeur_selection_region)){
                            ?>
                            <option value="<?php echo $row["id"] ?>"><?php echo $row["region"] ?></option>
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
                    <select name="environnement" class="select_form" id="environnement" required="required">
                        <option value="">-----séléctionner une environnement-----</option>
                        <?php
                        while($row = mysqli_fetch_assoc($valeur_selection_environnement)){
                            ?>
                            <option value="<?php echo $row["id"] ?>"><?php echo $row["environnement"] ?></option>
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
                    <select name="difficulte" class="select_form" id="deffecilte" required="required">
                        <option value="">-----séléctionner le niveau-----</option>
                        <?php
                        while($row = mysqli_fetch_assoc($valeur_selection_difficulte)){
                            ?>
                            <option value="<?php echo $row["id"] ?>"><?php echo $row["difficulte"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <p class="input_erreur" id="erreur_difficulte"></p>
                </div>

            </div>

            <div>
                <label>image</label><br/>
                <input type="file" name="image" placeholder="image" required="required" accept="image/png, image/jpeg"/>
                <p class="input_erreur" id="erreur_image"></p>
            </div>


            <div>
                <label>déscription</label><br/>
                <textarea name="description" placeholder="description" required="required" id="description"></textarea>
                <p class="input_erreur" id="erreur_description"></p>
            </div>

            <div>
                <input type="submit" name="submit" value="ajouter randonnée">
            </div>
        </form>
    </div>
</section>

<?php
    require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."footer.php");
?>

