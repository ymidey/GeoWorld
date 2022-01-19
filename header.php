<?php

/**
 * Fragment Header HTML page
 *
 * PHP version 7
 *
 * @category  Page_Fragment
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
    require_once 'javascripts.php';

    // On récupère la session
    session_start();

    // On vérifie si l'utilateur qui veut accéder à cette page est bien connecté à notre bdd
    // sinon on le renvoi sur la page login.php
    if (!isset($_SESSION['id'])) {
        header('location: login.php');
    }

    // On vérifie si le paramètre 'recherche' a été reçu dans l'url
    if (isset($_GET['recherche'])) {
        // On donne la valeur 'recherche' à une variable nommé $pays
        $pays = $_GET['recherche'];
        // On vérifie si nous nous trouvons par déja sur '/geoworld/pays.php?recherche=$pays'
        if ($_SERVER['REQUEST_URI'] != "/geoworld/pays.php?recherche=$pays") {
            // Si cette ligne retourne True, nous somme redirigé sur la page 'pays.php?recherche=$pays'
            header("location: pays.php?recherche=$pays");
        }
    }
    // On appel la fonction continent afin d'avoir la liste des continents
    $lesContinents = getContinents();

    ?>
<!doctype html>
<html lang="fr" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>Homepage : GeoWorld</title>

  <!-- Bootstrap core CSS -->
  <link href="assets/bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/map.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">

</head>

<body class="d-flex flex-column h-100">
  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php">GeoWorld</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Continents</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <?php foreach ($lesContinents as $leContinent) : ?>
                <a class="dropdown-item" href="continent.php?Continent=<?php echo $leContinent->Continent; ?>"><?php echo $leContinent->Continent; ?></a>
              <?php endforeach; ?>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if (isset($_SESSION['role']) and ($_SESSION['role'] == ('admin'))) : ?>
            <li class="nav-item">
              <a class="nav-link" href="./espaceAdmin.php">Panel d'administration</a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['role']) and $_SESSION['role'] == ('professeur')) : ?>
            <li class="nav-item">
              <a class="nav-link" href="register.php?url=<?php echo $_SERVER['REQUEST_URI'] ?>">Enregistrer un élève</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="infoEleve.php">Modifier des données d'élève</a>
            </li>
          <?php endif; ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon compte</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="espaceMembre.php?Compte=<?php echo $_SESSION['id']; ?>">Mon compte</a>
              <a class="dropdown-item" href="logout.php?>">Se deconnecter</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <div class="search">
            <div class="searchbox">
              <input type="text" class="searchbox__input" placeholder="Nom du pays..." name="recherche" />
              <svg class="searchbox__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.966 56.966">
                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z" />
              </svg>
            </div>
        </form>
      </div>
    </nav>
  </header>