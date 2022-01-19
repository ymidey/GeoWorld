<?php

/**
 * Vérification de l'inscription d'un nouveau membre
 *
 * PHP version 7
 *
 * @category  Page-Verif
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

// On vérifie si c'est un utilisateur autre qu'un admin ou un professeur qui veut accéder à la page, si 
// c'est le cas la connexion est interrompu et une redirection vers index.php est effectué
if (!isset($_SESSION['role']) or $_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
    header('location: index.php');
}

// On récupère le paramètre 'url' situé dans l'url
$url = $_POST['url'];

// On vérifie si les mots ne correspondent pas
if ($_POST['password'] !== $_POST['password_confirm']) :
    // Si c'est le cas, l'utilisateur est redirigé sur 'register.php?erreur'
    header('location: register.php?erreur&url='.$url.''); 
    // Si ce n'est pas le cas, on initialise chaque variable avec les parametre reçu dans l'url
    // puis on fait appel à la fonction ajouterUnUtilisateur avec comme valeur les différentes variables
elseif (isset($_POST['ajouter'])) :
    $nom = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['choixUtil'];
    ajouterUnUtilisateur($nom, $password, $email, $role);?>
  <SCRIPT LANGUAGE="JavaScript">
document.location.href="<?php echo $url?>"
</SCRIPT>

<?php endif;?>
