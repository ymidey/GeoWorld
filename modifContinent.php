<?php

/**
 * Page du site internet permettant de modifier les informations d'un pays
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

    ini_set('display_errors', 'off');

    // On récupère la session
    session_start();
    // On vérifie si c'est un utilisateur autre qu'un admin ou un professeur qui veut accéder à la page, si 
    // c'est le cas la connexion est interrompu et une redirection vers index.php est effectué
    if (!isset($_SESSION['role']) or $_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
        header('location: index.php');
    }

    // On récupère le paramètre 'id' situé dans l'url
    $id = $_GET['id'];
    // On appel la fonction getPays avec comme paramètre la variable $id
    $pays = getPays($id);
    // On récupère le paramètre 'continent' situé dans l'url
    $url = $_GET['Continent'];

    ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>modifContinent</title>
    <link href="css/modificationPaysxContinent.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <!-- zone de connexion -->
        <?php echo "<h1>$pays->Pays</h1>" ?>
    </div>
    <?php echo $url1 . $url2 . $url3; ?>
    <form method="post" action="<?php echo 'continent.php?Continent=' . $url . '' ?>">
        <div class="input-group">
            Population : <input type="text" name="Populations" value="<?php echo  $pays->Population ?>"><br>
            Superficie : <input type="text" name="Superficie" value="<?php echo $pays->SurfaceArea ?>"><br>
            Capital : <input type="text" name="Capital" value="<?php echo $pays->Name ?>"><br>
            Région : <input type="text" name="Region" value="<?php echo $pays->Region ?>"><br>
            PNB : <input type="text" name="PNB" value="<?php echo $pays->GNP ?>"><br>
            Chef d'état : <input type="text" name="ChefDetat" value="<?php echo $pays->HeadOfState ?>"><br>
            <input type="hidden" name="Pays" value="<?php echo $pays->Pays ?>"><br>
            <input type="hidden" name="id" value="<?php echo $pays->id ?>"><br>
            <input type="submit" class="btn" name="update" value="Insérer">
    </form>
    </div>
</body>

</html>
