<?php

/**
 * Page du site internet permettant de ce déconnecter du site 
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
// On récupère la session
session_start();
// On détruit les variables de notre session
session_unset();
// On détruit notre session
session_destroy();
// On redirige le visiteur vers la page d'accueil
header('location: index.php');
?>
