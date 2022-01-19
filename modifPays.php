<?php

/**
 * Page du site internet permettant de modifier les informations d'une ville d'un pays
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
    require_once './inc/manager-db.php';

    // On récupère la session
    session_start();

    // On vérifie si c'est un utilisateur autre qu'un admin ou un professeur qui veut accéder à la page, si 
    // c'est le cas la connexion est interrompu et une redirection vers index.php est effectué
    if (!isset($_SESSION['role']) or $_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
        header('location: index.php');
    }

    // On récupère le paramètre 'id' situé dans l'url
    $id = $_GET['id'];
    // On récupère le paramètre 'url' situé dans l'url
    $url = $_GET['url'];
    // On fait appel à la fonction getVilleInfo avec comme valeur, la variable $ville
    $ville = getVilleInfo($id);
    ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>modifPays</title>
    <link href="css/modificationPaysxContinent.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <!-- zone de connexion -->
        <h1>Modification</h1>
    </div>
    <form method="post" action="<?php echo $url; ?>">
        <div class="input-group">
            Nom : <input type="text" name="Nom" value="<?php echo  $ville->Name ?>"><br>
            Population : <input type="text" name="Populations" value="<?php echo  $ville->Population ?>"><br>
            Région : <input type="text" name="District" value="<?php echo $ville->District ?>"><br>
            <input type="hidden" name="id" value="<?php echo $ville->id ?>"><br>
            <input type="submit" class="btn" name="update" value="Insérer">


    </form>
</body>

</html>
