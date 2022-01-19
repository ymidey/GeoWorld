<?php

/**
 * Page du site internet permettant d'avoir les informations des pays en fonction d'un continent
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
ini_set('display_errors', 'off');

//La page vérifie si elle a reçu en paramètre 'update' 
if (isset($_POST['update'])) : ?>
  <!---La page vérifie si la ville existe dans ce pays!-->
    <?php if (!villeExistePays($_POST['Capital'], $_POST['Pays'])) : ?>
    <script>
    // Si la fonction retourne false, une redirection vers index.php est effectué
      window.location = "index.php?error1&pays=<?php echo $_POST['Pays'] ?>";
    </script>
  <?php else :
      // Si la fonction retourne true, on fait appel à la fonction updateContinent avec comme parametre, les informations reçu dans l'url
      updateContinent($_POST['Populations'], $_POST['Superficie'], $_POST['Capital'], $_POST['Region'], $_POST['PNB'], $_POST['ChefDetat'], $_POST['id']); ?>
  <?php endif; ?>
<?php endif; ?>
<?php

// On récupère le paramètre 'Continent' situé dans l'url
$continent = $_GET['Continent'];

// On vérifie si les paramètres 'tri' et 'ordre' ont été reçu dans l'url
if (isset($_GET['tri']) && (isset($_GET['ordre']))) {
    // Si ils ont été reçu, on appel la fonction getCountriesByContinent avec comme valeur les paramètres 
    // 'tri' ainsi que le paramètre 'ordre'
    $desPays = getCountriesByContinent($continent, $_GET['tri'], $_GET['ordre']);
} else {
    // Sinon on envoi comme paramètre par défaut 'pays' pour le tri et 'ASC' pour l'ordre
    $desPays = getCountriesByContinent($continent, 'Pays', 'ASC');
}

?>


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="css/PaysxContinent.css" rel="stylesheet">
</head>

<body>
  <h1>
    <?php echo "<h1>Les pays en $continent</h1>" ?>
  </h1>
  <h2>
    <form method="GET" action="continent.php">
      Trier par :
      <select name="tri">
        <option value="Pays">Pays</option>
        <option value="Population">Population</option>
        <option value="SurfaceArea">Superficie</option>
        <option value="Region">Région</option>
        <option value="Name">Capital</option>
        <option value="GNP">PNB</option>
        <option value="HeadOfState">Chef d'état</option>
      </select><br>
      ordre :
      <select name="ordre">
        <option value="ASC">Croissant/Alphabétique(A-Z)</option>
        <option value="DESC">Decroissant/Alphabétique(Z-A)</option>
      </select>
      <input type="hidden" name="Continent" value="<?php echo $continent ?>"><br><br>
      <button type="submit" class="btn">enregistrer</button>
  </h2>
  <hr>
  <div class="responsive-table-line">
    <table>
      <thead>
        <tr id="header">
          <th>Pays<div class="hidden">hidden</div><?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Pays&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les pays par ordre Alphabétique de A à Z"></a>'; ?>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Pays&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les pays par ordre Alphabétique de Z à A"></a>'; ?>
          </th>
          <th>Population<?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Population&ordre=ASC">
                <img class ="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri de la population par ordre croissante (de la plus petite à la plus grande)"></a>'; ?></a>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Population&ordre=DESC">
                <img class ="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les populations par ordre decroissante (de la plus grande à la plus petite)"></a>'; ?></a>
          </th>

          <th>Superficie(km2)<?php echo '<a href="continent.php?Continent=' . $continent . '&tri=SurfaceArea&ordre=ASC">
                <img class="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri de la superficie par ordre croissante (de la plus petite à la plus grande)"></a>'; ?></a>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=SurfaceArea&ordre=DESC">
                <img class="flecheBas" src="./images/fleche-versBas.PNG" Title="tri de la superficie par ordre decroissante (de la plus grande à la plus petite)"></a>'; ?></a>
          </th>

          <th>Région<?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Region&ordre=ASC">
                <img class="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri de la superficie par ordre croissante (de la plus petite à la plus grande)"></a>'; ?></a>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Region&ordre=DESC">
                <img class="flecheBas" src="./images/fleche-versBas.PNG" Title="tri de la superficie par ordre decroissante (de la plus grande à la plus petite)"></a>'; ?></a>
          </th>

          <th>Langue officiel</th>

          <th>Capital<?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Name&ordre=ASC">
                <img class="flecheHaut" src="./images/fleche-versHaut.PNG" Title="tri les capitales des pays par ordre Alphabétique de A à Z"></a>'; ?></a>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=Name&ordre=DESC">
                <img class="flecheBas" src="./images/fleche-versBas.PNG" Title="tri les capitales des pays par ordre Alphabétique de Z à A"></a>'; ?></a>
          </th>

          <th>PNB<div class="hidden">hidden</div><?php echo '<a href="continent.php?Continent=' . $continent . '&tri=GNP&ordre=ASC">
                <img class="flecheHaut" src="./images/fleche-versHaut.PNG" alt="tri du gnp par ordre croissant (du plus petit au plus gros)"></a>'; ?>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=GNP&ordre=DESC">
                <img class="flecheBas" src="./images/fleche-versBas.PNG" alt="tri du gnp par ordre decroissant (du plus gros au plus petit)"></a>'; ?>
          </th>

          <th>Chef d'état<?php echo '<a href="continent.php?Continent=' . $continent . '&tri=HeadOfState&ordre=ASC">
                <img class="flecheHaut" src="./images/fleche-versHaut.PNG" alt="tri du nom des chefs d\'états par ordre alphabétique de A à Z"></a>'; ?>
            <?php echo '<a href="continent.php?Continent=' . $continent . '&tri=HeadOfState&ordre=DESC">
                <img class="flecheBas" src="./images/fleche-versBas.PNG" alt="tri du nom des chefs d\'états par ordre alphabétique de Z à A"></a>'; ?>
          </th>

          <?php if (($_SESSION['role'] == 'admin' or $_SESSION['role'] == 'professeur')) : ?>
            <th>Modifier</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // $desPays est un tableau dont les éléments sont des objets représentant
        // des caractéristiques d'un pays (en relation avec les colonnes de la table Country)
        foreach ($desPays as $pays) : ?>
          <tr>
            <td data-title="Pays"><a href=" pays.php?Pays=<?php echo $pays->Pays ?>"><?php echo $pays->Pays ?></td>
            <td data-title="Population"><?php echo $pays->Population ?> hab.</td>
            <td data-title="Superficie(km2)"><?php echo $pays->SurfaceArea ?></td>
            <td data-title="Région"><?php echo $pays->Region ?></td>
            <?php $langue = (array(getLanguePays($pays->Pays)));
            foreach ($langue as $LanguePays) :
                if (array_key_exists('Name', $LanguePays)) : ?>
                <td data-title="Langue"><?php echo $LanguePays->Name ?><br></td>
                <?php else : ?>
                <td data-title="Langue">Données non disponible</td>
                <?php endif; ?>
            <?php endforeach; ?>
            <td data-title="Capital"><?php echo $pays->Name; ?><br></td>
            <td data-title="PNB"><?php echo $pays->GNP ?></td>
            <td data-title="Chef d'état"><?php echo $pays->HeadOfState ?></td>
            <?php if (($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'professeur')) : ?>
              <td data-title="Modifier">
                <a href="modifContinent.php?id=<?php echo $pays->id ?>&Continent=<?php echo $continent ?>">editer
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
<?php require_once 'footer.php'; ?>