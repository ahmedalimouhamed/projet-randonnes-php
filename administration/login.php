<?php
    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."header.php");
    if(logged_in()){
        header("Location: randonnees.php");
    }
    if(isset($_POST['submit'])){
        $login_administrateur = securiser_input($_POST['login_administrateur']);
        $mot_de_passe = securiser_input($_POST['mot_de_passe']);

        $wheres = [
            'login_administrateur' => $login_administrateur,
            'mot_de_passe' => $mot_de_passe
        ];

        echo "<a name='login_erreur'></a>";
        //$sql = "SELECT * FROM administrateur WHERE ".prepare_string($wheres, 2);
        //echo "<h2>$sql</h2>";
        $resultats = login('administrateur', $wheres);
        if($resultats && $resultats->num_rows > 0){
            $_SESSION['utilisateur'] = $login_administrateur;
            header("Location:randonnees.php#table");
        }else{
            echo "<div class ='erreur_message'>login ou mot de passe incorrect<div class='fermer_message_err_scc'></div></div>";

        }

    }
?>
<a name="login"></a>
<section class="section_form_administration">
    <div class="inner_container">
        <h1 class="titre_h1">login</h1>
        <form action="#login_erreur" method="post" enctype="multipart/form-data" class="form login_form clearfix">
            <div class="img_login"></div>
            <div class="clearfix">
                <label>nom d'utilisateur</label><br/>
                <input type="text" name="login_administrateur" placeholder="login d'administrateur" required="required" value ="<?php echo (isset($_POST['login_administrateur']))? $_POST['login_administrateur'] : ''?>"/>
            </div>
            <div class="clearfix">
                <label>mot de passe</label><br/>
                <input type="password" name="mot_de_passe" placeholder="mot de passe" required="required" value ="<?php echo (isset($_POST['mot_de_passe']))? $_POST['mot_de_passe'] : '' ?>"/>
            </div>
            <div class="clearfix">
                <input type="submit" name="submit" value="se connecter">
            </div>
        </form>
    </div>
</section>
<?php
require_once(APP_LOCATION.DS."template".DS."footer.php");
?>
