<?php

/**
 * Page du site internet permettant d'avoir les informations des villes en fonction d'un pays
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
    require_once 'header.php';

    // On vérifie si le paramètre 'ajouter' a été reçu dans l'url
    if (isset($_POST['ajouter'])) {
        ajouterUneVille($_POST['idPays'], $_POST['Nom'], $_POST['Population'], $_POST['District']);
    }

    // On vérifie si le paramètre 'update' a été reçu dans l'url
    if (isset($_POST['update'])) {
        // S'il a été reçu, on fait appel à la fonction uptadeVille avec comme paraètre,
        // les valeurs 'Nom', 'Populations', 'District' ainsi que 'id' situé dans l'url
        updateVille($_POST['Nom'], $_POST['Populations'], $_POST['District'], $_POST['id']);
    }

    // On vérifie si le paramètre 'supprimer' a été reçu dans l'url
    if (isset($_GET['supprimer'])) {
        // Si c'est le cas, on fait appel à la fonction supprimerUneVille,
        // en lui donnant comme la valeur, le paramètre 'supprimer'
        supprimerUneVille($_GET['supprimer']);
    }

    // On vérifie si le paramètre 'Pays' a été reçu dans l'url
    if (isset($_GET['Pays'])) {
        // Si c'est le cas, la variable $pays est égal à 'Pays'
        $pays = $_GET['Pays'];
    } else {
        // Si ce n'est pas le cas, la variable $pays est égal à 'recherche'
        $pays = $_GET['recherche'];
    }

    // On vérifie si le pays recherché existe
    if (!paysExiste($pays)) : ?>
    <!-- Si ce n'est pas le cas, on redirige l'utilisateur vers 'index.php?error'!-->
  <script>
    window.location = "index.php?error";
  </script>
    <?php endif; ?>

<?php
// On initialise la variable $drapeau avec comme valeur,ce que retourne la fonction getDrapeauCountry
$drapeau = getDrapeauCountry($pays);

// On vérifie si les paramètres 'tri' et 'ordre' ont été reçu dans l'url
if (isset($_GET['tri']) and (isset($_GET['ordre']))) {
    // Si ils ont été reçu, on appel la fonction getVilleByCountry avec comme valeur les paramètres 
    // 'tri' ainsi que le paramètre 'ordre'
    $desVilles = getVilleByCountry($pays, $_GET['tri'], $_GET['ordre']);
} else {
    // Sinon on envoi comme paramètre par défaut 'Name' pour le tri et 'ASC' pour l'ordre
    $desVilles = getVilleByCountry($pays, 'Name', 'ASC');
}

?>

<head>
  <link href="css/PaysxContinent.css" rel="stylesheet">
</head>

<body>

  <h1>
    <?php $filename = strtolower($drapeau->Code2);
    // On vérfie si le drapeau du pays existe dans l'url 'images/drapeau/" . $filename . ".png'
    if (file_exists("images/drapeau/" . $filename . ".png")) : ?>
      <img class="test" src="images/drapeau/<?php echo $filename; ?>.png" /><?php echo "$pays"; ?>

    <?php elseif (print "$pays"
) : ?>
    <?php endif ?>
  </h1>
  <h2>
    <form method="GET" action="pays.php">
      Trier par :
      <select name="tri">
        <option value="Name">Nom</option>
        <option value="Population">Population</option>
        <option value="Distrct">Région</option>
      </select><br>
      ordre :
      <select name="ordre">
        <option value="ASC">Croissant/Alphabétique(A-Z)</option>
        <option value="DESC">Decroissant/Alphabétique(Z-A)</option>
      </select>
      <input type="hidden" name="Pays" value="<?php echo $pays ?>"><br><br>
      <button type="submit" class="btn">enregistrer</button>

  </h2>
  <hr>
  <div class="responsive-table-line">
    <table>
      <thead>
        <tr id="header">
          <th>Nom de la ville<div class="hidden">hidden</div><?php echo '<a href="pays.php?Pays=' . $pays . '&tri=Name&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri des villes par ordre Alphabétique de A à Z"></a>'; ?>
            <?php echo '<a href="pays.php?Pays=' . $pays . '&tri=Name&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri des villes par ordre Alphabétique de Z à A"></a>'; ?></th>

          <th>Population<div class="hidden">hidden</div><?php echo '<a href="pays.php?Pays=' . $pays . '&tri=Population&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les populations par ordre croissante (de la plus petite à la plus grande)"></a>'; ?>
            <?php echo '<a href="pays.php?Pays=' . $pays . '&tri=Population&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les populations par ordre decroissante (de la plus grande à la plus petite)"></a>'; ?></th>

          <th>Région<div class="hidden">hidden</div><?php echo '<a href="pays.php?Pays=' . $pays . '&tri=District&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les région par ordre Alphabétique de A à Z"></a>'; ?>
            <?php echo '<a href="pays.php?Pays=' . $pays . '&tri=District&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les région par ordre Alphabétique de Z à A"></a>'; ?></th>

          <?php if (($_SESSION['role'] == 'admin' or $_SESSION['role'] == 'professeur')) : ?>
            <th>Modifier</th>
            <th>Supprimer</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // $desPays est un tableau dont les éléments sont des objets représentant
        // des caractéristiques d'un pays (en relation avec les colonnes de la table Country)
        foreach ($desVilles as $ville) : ?>
          <tr>
            <td data-title="Nom de la ville"><?php echo $ville->Name ?></td>
            <td data-title="Population"><?php echo $ville->Population ?> hab.</td>
            <td data-title="Région"><?php echo $ville->District ?></td>
            <?php if (($_SESSION['role'] == 'admin' or $_SESSION['role'] == 'professeur')) : ?>
              <td data-title="Modifier">
                <a href="modifPays.php?id=<?php echo $ville->id; ?>&url=<?php echo $_SERVER['REQUEST_URI'] ?>">Editer</a>
              </td>
              <td data-title="Supprimer">
                <a href="pays.php?Pays=<?php echo $pays; ?>&supprimer=<?php echo $ville->id ?>">Supprimer</a>
            </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br>
  <?php if (($_SESSION['role'] == 'admin' or $_SESSION['role'] == 'professeur')) : ?>
    <a class="lien" href="AjoutVille.php?pays=<?php echo $pays; ?>&url=<?php echo $_SERVER['REQUEST_URI'] ?>">Ajoutez une ville ?</a>
  <?php endif; ?>
</body>
<?php require_once 'footer.php'; ?>
