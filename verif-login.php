<?php

/**
 * Vérification de la demande de connexion d'un membre au site
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
    // on teste si nos variables sont définies et remplies

    if (isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login'])&& !    empty($_POST['login'])) {
        // on appele la fonction getAuthentification en lui passant en paramètre le login et password
        //la fonction retourne les caractéristiques du membre si il est connu sinon elle retourne false
        $result = getAuthentification($_POST['login'], $_POST['password']);
        // si le résulat n'est pas false
        if ($result) {
            // on démarre la session
            session_start();
            // on enregistre les paramètres de notre visiteur comme variables de session
            $_SESSION['login'] = $result->login;
            $_SESSION['id'] = $result->idmembre;
            $_SESSION['role'] = $result->role;

            // on redirige notre visiteur vers la page principal de notre site
            header('location: index.php');

        } else {
            header('location : login.php?erreur');
            //si le résultat est false on redirige vers la page d'authentification
        }
        
    } else {
        header('location : login.php');
    }
    ?>
