<?php
    require_once("template".DIRECTORY_SEPARATOR."header.php");



    if(isset($_POST['submit'])){
        $nom = securiser_input($_POST['nom']);
        $prenom = securiser_input($_POST['prenom']);
        $activite = securiser_input($_POST['activite']);
        $fonction = securiser_input($_POST['fonction']);
        $adresse = securiser_input($_POST['adresse']);
        $ville = securiser_input($_POST['ville']);
        $tel = securiser_input($_POST['tel']);
        $objet = securiser_input($_POST['objet']);
        $message = securiser_input($_POST['message']);


        $nom_table = 'contact_us';
        $champs = [
            'nom' => $nom,
            'prenom' => $prenom,
            'activite' => $activite,
            'fonction' => $fonction,
            'adresse' => $adresse,
            'ville' => $ville,
            'tel' => $tel,
            'objet' => $objet,
            'message' => $message
        ];

        try{
            if(ajouter($nom_table, $champs)) {
                $_SESSION['success'] = "<h2>les champs saisis avec succés</h2>";
                header("Location:" . NOM_HOST . "index.php");
            }else{
                throw new Exception("erreur de saisi sur la table ".$nom_table);
            }
        }catch(Exception $e){
            $_SESSION['erreur'] = "<h2>erreur ".$e->getMessage()."</h2>";
            header("Location:" . NOM_HOST . "index.php");;
        }


    }

?>

<section class="section_form_administration">
    <div class="inner_container">
        <a name='ajouter'></a>
        <h1 class="titre_h1">Contacter Nous</h1>
        <form action="" method="post" enctype="multipart/form-data" class="form form_administration ajout_randonnees_form
clearfix" onsubmit="return valider_la_forme()" id="ajouter_denivele">
            <div>
                <label>nom</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="nom" placeholder="nom" id="nom"/>
                    <p class="input_erreur" id="erreur_nom"></p>
                </div>

            </div>
            <div>
                <label>Prénom</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="prenom" placeholder="prénom" id="prenom"/>
                    <p class="input_erreur" id="erreur_prenom"></p>
                </div>

            </div>
            <div>
                <label>Activité</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="activite" placeholder="activité" id='activite'/>
                    <p class="input_erreur" id="erreur_activite"></p>
                </div>
            </div>
            <div>
                <label>Fonction</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="fonction" placeholder="Fonction" id='fonction'/>
                    <p class="input_erreur" id="erreur_fonction"></p>
                </div>
            </div>
            <div>
                <label>Addresse</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="adresse" placeholder="adresse" id='adresse'/>
                    <p class="input_erreur" id="erreur_adresse"></p>
                </div>
            </div>
            <div>
                <label>Ville</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="ville" placeholder="Ville" id='ville'/>
                    <p class="input_erreur" id="erreur_ville"></p>
                </div>
            </div>

            <div>
                <label>Tél</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="tel" placeholder="tel" id='tel'/>
                    <p class="input_erreur" id="erreur_tel"></p>
                </div>
            </div>
            <div>
                <label>Objet</label><br/>
                <div class="input_div clearfix">
                    <input type="text" name="objet" placeholder="Objet" id='objet'/>
                    <p class="input_erreur" id="erreur_objet"></p>
                </div>
            </div>
           
            <div>
                <label>méssage</label><br/>
                <textarea name="message" placeholder="méssage" required="required" id="message"></textarea>
                <p class="input_erreur" id="erreur_message"></p>
            </div>

            <div>
                <input type="submit" name="submit" value="Contacter Nous">
            </div>
        </form>
    </div>
</section>

<?php
    require_once("template".DS."footer.php");
?>
