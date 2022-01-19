<?php

/**
 * Page du site internet permettant d'enregister un nouvel utilisateur
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

// On vérifie si c'est un utilisateur autre qu'un admin ou un professeur qui veut accéder à la page, si 
// c'est le cas la connexion est interrompu et une redirection vers index.php est effectué
if (!isset($_SESSION['role']) or $_SESSION['role'] != 'admin' and $_SESSION['role'] != 'professeur') {
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Enregistrement des utilisateurs</title>
    <link href="css/register.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <h2>Créer un nouvel utilisateur</h2>
    </div>

    <form method="POST" action="verif-inscription.php">

        <div class="input-group">
            <label>Son Nom</label>
            <input type="text" placeholder="Entrer un nom d'utilisateur" name="username" required>


            <label>Son adresse email</label>
            <input type="email" placeholder="Entrer une adresse e-mail" name="email" required>

            <label>Son mot de passe</label>
            <input type="password" placeholder="Entrer un mot de passe" name="password" required>

            <label>Entrez le mot de passe de nouveau</label>
            <input type="password" name="password_confirm" required>


            <label for="choixUtil">Le nouvel utilisateur sera un :</label>

            <select name="choixUtil" id="ChoixUtil">
                <?php if (($_SESSION['role']) == 'admin') : ?>
                    <option value="professeur">professeur</option>
                <?php endif; ?>
                <option value="eleve">eleve</option>
            </select>
            </br></br>
            <input type="hidden" name="url" value="<?php echo $_GET['url']; ?>"><br>
            <button type="submit" class="btn" name="ajouter">Enregistrer</button>
        </div>

        <?php
        if (isset($_GET['erreur'])) {
            $err = $_GET['erreur'];

            echo "<p style='color:red'>les mots de passes ne correspondent pas </p>";
        }
        ?>
    </form>
    <button class="btn2" onclick="window.location.href = '<?php echo $_GET['url']; ?>'">Annuler l'ajout</button>
</body>

</html>
