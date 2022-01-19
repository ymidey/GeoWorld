<?php

/**
 * Page du site internet permettant de ce connecter à la bdd afin d'avoir accès au site
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
    // On vérifie qu'une séssion n'existe pas encore
    if (!isset($_SESSION)) {
        // On récupère la session
        session_start();
    }
    ?>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>login</title>
    <link href="css/login.css" rel="stylesheet">
</head>

<body>

    <div class="header">
        <!-- zone de connexion -->
        <h1>Connexion</h1>
    </div>
    <form action="verif-login.php" method="POST">

        <div class="input-group">
            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="login" required>
        </div>
        <div class="input-group">
            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" required>

        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="Connexion">se connecter</button>
            <?php
            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];

                echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
            }
            ?>
        </div>
    </form>
    </div>
</body>

</html>
