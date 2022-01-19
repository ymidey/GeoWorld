<?php

/**
 * Page du site internet permettant au membre de connaitre ses informations personnels 
 *
 * PHP version 7
 *
 * @category  Page-Body
 * @package   Application
 * @author    Yannick MIDEY <midey.yannick0@gmail.com>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/ymidey/geoworld
 */

?>

 <?php
    // On récupère nos fichiers essentiels au bon fonctionnement du site
    require_once 'inc/manager-db.php';

    // On récupère la session
    session_start();

    // On vérifie si l'utilisateur qui veut acceder à cette page à bien les bonnes informations
    // si ce n'est pas le cas, il est renvoyé sur index.php
    if (!isset($_SESSION['id']) or ($_SESSION['id'] != $_GET['Compte'])) {
        header('location: index.php');
    }

    // On vérifie si le paramètre 'Compte' a été reçu dans l'url
    if (isset($_GET['Compte'])) {
        // Si c'est le cas, on fait appel à la fonction getMembre avec comme valeur, le paramètre 'Compte' 
        $listeMembre = getMembre($_GET['Compte']);
    } ?>


<!DOCTYPE html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Enregistrement des utilisateurs</title>
    <link href="css/espaceMembre.css" rel="stylesheet">
</head>



<body>
    <div class="header">
        <?php foreach ($listeMembre as $membre):?>
        <h2>Bienvenue dans votre espace membre <br> voici vos informations :</h2>
    </div>
    <div class="body">
        Votre Login : <b><?php echo $membre->login; ?></b><br>
        Votre adresse mail : <b><?php echo $membre->Email; ?></b><br>
        La Date de création de votre compte : <b><?php echo $membre->Date_Creation; ?></b><br>
        Votre mot de passe : <b><?php echo $membre->MotDePasse; ?></b><br>
        Votre Role : <b><?php echo $membre->role; ?></b></label><br><br>
        <b class="important">Attention</b><br>
        Pour toute modification, merci de contacter votre professeur ou l'administrateur du site<br><br>
        <a href="index.php">Retourner à l'acceuil</a><br>
        <a href="logout.php">Se déconnecter</a>
    </div>
        <?php endforeach;?>
</body>

</html>
