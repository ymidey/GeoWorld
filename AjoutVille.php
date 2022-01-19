<?php
/**
 * Page du site internet permettant d'avoir les informations des villes d'un pays
 *
 * PHP version 7
 *
 * @category  WebPage
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
// c'est le cas, la connexion est interrompu et une redirection vers index.php est effectué
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
    header('location: index.php');
}

// On récupère le paramètre 'pays' situé dans l'url
$idPays = idpays($_GET['pays']);
// On récupère le paramètre 'url' situé dans l'url
$url = $_GET['url']
?>

<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Ajout ville</title>
    <link href="css/ajout.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <h1>Ajout d'une ville</h1>
    </div>
    <form method="post" action="<?php echo $url ?>">
        <div class="input-group">
            Nom : <input type="text" name="Nom" required><br>
            Population : <input type="text" name="Population" required><br>
            Région : <input type="text" name="District" required><br>
            <input type="hidden" name="idPays" value="<?php echo $idPays->id ?>"><br>
            <button type="submit" class="btn" name="ajouter">Ajouter</button>
        </div>
    </form>
    <button class="btn2" onclick="window.location.href = '<?php echo $_GET['url']; ?>'">Annuler l'ajout</button>
</body>

</html>
