<?php

/**
 * Page du site internet permettant de modifier les informations d'un membre
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
    require_once './inc/admin-db.php';

    // On récupère la session
    session_start();

    // On vérifie si c'est un utilisateur autre qu'un admin ou un professeur qui veut accéder à la page, si 
    // c'est le cas la connexion est interrompu et une redirection vers logout.php est effectué
    if ($_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
        header('location: logout.php');
    }

    // On récupère le paramètre 'modifier' situé dans l'url
    $idmembre = $_GET['modifier'];
    // on fait appel à la fonction getMembreModif avec comme paramétre, la fonction $membre
    $membre = getMembreModif($idmembre);
    // On récupère le paramètre 'url' situé dans l'url
    $url=$_GET['url'];
    ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>modifMembre</title>
    <link href="css/modifMembre.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <!-- zone de connexion -->
        <h1>Modification</h1>
    </div>
    <form method="post" action="<?php echo $url?>">
        <div class="input-group">
            Login : <input type="text" name="Login" value="<?php echo $membre->login ?>" required><br>
            Mot de passe : <input type="password" name="MDP" value="<?php echo  $membre->MotDePasse ?>" required><br>
            Email : <input type="email" name="Email" value="<?php echo $membre->Email ?>"><br><br>
            Role : <select name="choixUtil" id="ChoixUtil">
                <?php if (($_SESSION['role']) == 'admin') : ?>
                    <option value="professeur">Professeur</option>
                <?php endif; ?>
                <option value="eleve">Eleve</option>
            </select><br>
            <input type="hidden" name="idmembre" value="<?php echo $membre->idmembre ?>"><br>
            <input type="submit" class="btn" name="Modifier" value="Modifier">


    </form>
</body>

</html>
