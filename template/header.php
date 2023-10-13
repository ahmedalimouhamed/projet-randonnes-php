<?php
    require_once(dirname(__DIR__).DIRECTORY_SEPARATOR."init.php");
    require_once(DB.DS."sql_fonctions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="<?php echo CSS."style.css" ?>" type="text/css">

</head>
<body>
<div class="message_bien_venue clearfix">
    <h1 class="message_bien_venue">Bienvenue au Maroc</h1>
</div>
<div class="wrapper">
    <header>
        <nav>
            <ul class="navbar">
                <li <?php if(page_activee() == 'index.php' || page_activee() == 'login.php') echo "class= 'active'"?>><a href=<?php echo NOM_HOST ."index.php"?>>acceuil</a></li>
                <li <?php if(page_activee() == 'qui_somme_nous.php')echo "class= 'active'" ?>><a href=<?php echo NOM_HOST.'qui_somme_nous.php#qui_somme_nous'?>>qui somme nous</a></li>
                <li <?php if(page_activee() == 'contacter_nous.php' || page_activee() == 'contacts.php' )echo "class= 'active'" ?>><?php if (logged_in()) echo "<a href='".ADMINISTRATION_PAGE."contacts.php'>Contacts</a>"; else echo "<a href='".NOM_HOST."contacter_nous.php#contacter_nous'>contacter nous</a>"?></li>
                <li <?php if(page_activee() != 'index.php' && page_activee() != 'qui_somme_nous.php' && page_activee() != 'login.php' && page_activee() != 'contacter_nous.php' && page_activee() != 'contacts.php')echo "class= 'active'" ?>><a href=<?php echo NOM_HOST .'randonnees.php#table'?>>randonnées</a></li>
                <li class="right">
                    <?php if (logged_in()) echo "<a href='".ADMINISTRATION_PAGE."logout.php'>se déconnecter</a>";
                    else echo "<a href='".ADMINISTRATION_PAGE."login.php#login'>se connecter</a>"?>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container_wrapper clearfix">
        <div class="barre header"></div>
        <!--<div class="body">-->
        <section class="banner clearfix"  id="bienvenu">
            <img src="<?php echo NOM_HOST.'/images/banner_4.jpg'?>"/>
        </section>
