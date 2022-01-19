<?php

/**
 * Page du site internet ouverte seulement au professeur, permettant d'administrer chacun des élèves inscrit sur le site
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

// On vérifie si c'est un utilisateur autre qu'un professeur qui veut accéder à la page, si 
// c'est le cas, la connexion est interrompu et une redirection vers logout.php est effectué
if ($_SESSION['role'] != 'professeur') {
    header('location: logout.php');
}

// On vérifie si le paramètre 'Modifier' a été reçu dans l'url
if (isset($_POST['Modifier'])) {
    // Si c'est le cas, on appel la fonction uptadeMembre avec comme valeur, les paramètres
    // 'Login', 'MDP', 'Email', 'choixUtil' ainsi que 'idmembre' situé dans l'url
    updateMembre($_POST['Login'], $_POST['MDP'], $_POST['Email'], $_POST['choixUtil'], $_POST['idmembre']);
}

// On vérifie si le paramètre 'supprime' a été reçu dans l'url
if (isset($_GET['supprime'])) {
    // Si c'est le cas, on appel la fonction suprmMembreEleve avec comme valeur, le
    // paramètre 'supprime'
    suprmMembreEleve($_GET['supprime']);
}

// On vérifie si le paramètre 'Modifier' a été reçu dans l'url
if (isset($_GET['tri']) and (isset($_GET['ordre']))) {
    $desmembres = getEleveInfo($_GET['tri'], $_GET['ordre']);
} else {
    $desmembres = getEleveInfo('idmembre', 'DESC');
}
?>

<!DOCTYPE html>

<html lang="fr" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Info élèves</title>
    <link href="css/infoEleve.css" rel="stylesheet">
</head>

<body>
    <h1>Élèves inscrit sur le site internet</h1>
    <h2>
        <form method="GET" action="infoEleve.php">
            Trier par :
            <select name="tri">
                <option value="idmembre">IdMmembre</option>
                <option value="login">Login</option>
                <option value="MotDePasse">Mot de passe</option>
                <option value="email">Email</option>
                <option value="Date_Creation">Date de création</option>
            </select><br>
            ordre :
            <select name="ordre">
                <option value="ASC">Croissant/Alphabétique(A-Z)</option>
                <option value="DESC">Decroissant/Alphabétique(Z-A)</option>
            </select>

            <button type="submit" class="btn" name="Trier">enregistrer</button>
    </h2>
    <hr>
    <div class="responsive-table-line">
        <table>
            <thead>
                <tr id="header">
                    <th>idMembre<?php echo '<a href="infoEleve.php?tri=idmembre&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les membres en fonction de leur id par ordre croissant "></a>'; ?>
                        <?php echo '<a href="infoEleve.php?tri=idmembre&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les membres en fonction de leur id par ordre decroissant"></a>'; ?></th>

                    <th>Login<div class="hidden">hidden</div><?php echo '<a href="infoEleve.php?tri=login&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les membres en fonction de leur nom par ordre alphabétique de A à Z"></a>'; ?>
                        <?php echo '<a href="infoEleve.php?tri=login&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les membres en fonction de leur nom par ordre alphabétique de Z à A"></a>'; ?></th>

                    <th>Mot de passe<?php echo '<a href="infoEleve.php?tri=MotDePasse&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les mots de passes des membres par ordre alphabétique de A à Z"></a>'; ?>
                        <?php echo '<a href="infoEleve.php?tri=MotDePasse&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les mots de passes des membres par ordre alphabétique de Z à A"></a>'; ?></th>

                    <th>Email</th>

                    <th>Role</th>

                    <th>Date de création<?php echo '<a href="infoEleve.php?tri=Date_Creation&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les membres en fonction de la date de leur inscription par ordre croissant"></a>'; ?>
                        <?php echo '<a href="infoEleve.php?tri=Date_Creation&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les membres en fonction de la date de leur inscription par ordre décroissant"></a>'; ?></th>

                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($desmembres as $membre) : ?>
                    <tr>
                        <td data-title="idmembre"><?php echo $membre->idmembre ?></td>
                        <td data-title="login"><?php echo $membre->login ?> </td>
                        <td data-title="Mot de passe"><?php echo $membre->MotDePasse ?></td>
                        <td data-title="Email" class="email"><?php echo $membre->Email ?></td>
                        <td data-title="Role"><?php echo $membre->role ?></td>
                        <td data-title="Date de création"><?php echo $membre->Date_Creation ?></td>
                        <td data-title="Modifier"><a href="modifMembre.php?modifier=<?php echo $membre->idmembre ?>&url=<?php echo $_SERVER['REQUEST_URI']?>">Modifier</a></td>
                        <td data-title="Supprimer"><a href="infoEleve.php?supprime=<?php echo $membre->idmembre ?>">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class="lien">
        <a href="index.php">Retourner sur Géoworld ?</a>
    </div>
</body>

</html>
