<?php

/**
 * Ce script est composé de fonctions d'exploitation des données
 * détenues par le SGBDR MySQL utilisées par la logique de l'application.
 *
 * C'est le seul endroit dans l'application où a lieu la communication entre
 * la logique métier de l'application et les données en base de données, que
 * ce soit en lecture ou en écriture.
 *
 * PHP version 7
 *
 * @category  Database_Access_Function
 * @package   Application
 * @author    Yannick MIDEY <midey.yannick0@gmail.com>
 * @copyright 2019-2021 SIO-SLAM
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link      https://github.com/ymidey/geoworld
 */

/**
 *  Les fonctions dépendent d'une connection à la base de données,
 *  cette fonction est déportée dans un autre script.
 */
require_once 'connect-db.php';


/**
 * Obtenir la liste de tous les pays référencés d'un continent donné ainsi que de leur capital
 *
 * @param string $continent le nom d'un continent
 * @param string $tri       filtre l'ordre des
 *                          données
 * @param string $ordre     filtre l'ordre des
 *                          données
 * 
 * @return array tableau d'objets (des pays)
 */
function getCountriesByContinent($continent, $tri, $ordre)
{
    // pour utiliser la variable globale dans la fonction
    global $pdo;
    $query = "SELECT country.*,city.Name FROM Country,city
    WHERE  city.id = country.Capital and country.Continent = :cont order by $tri $ordre";
    $prep = $pdo->prepare($query);
    // on associe ici (bind) le paramètre (:cont) de la req SQL,
    // avec la valeur reçue en paramètre de la fonction ($continent)
    // on prend soin de spécifier le type de la valeur (String) afin
    // de se prémunir d'injections SQL (des filtres seront appliqués)
    $prep->bindValue(':cont', $continent, PDO::PARAM_STR);
    $prep->execute();

    // on retourne un tableau d'objets 
    return $prep->fetchAll();
}


/**
 * Obtenir la liste des pays
 *
 * @return list d'objets (les pays)
 */
function getAllPays()
{
    global $pdo;
    $query = 'SELECT Pays FROM Country;';

    return $pdo->query($query)->fetchAll();
}

/**
 * Obtenir la liste des continents
 *
 * @return array d'objets (les continents)
 */
function getContinents()
{
    global $pdo;
    $query = 'SELECT Distinct Continent FROM country;';

    return $pdo->query($query)->fetchAll();
}

/**
 * Modifie les données d'un pays en fonction des différents parametres 
 * 
 * @param string $population  le nombre d'habitant
 * @param string $surfaceArea la superficie du pays
 * @param string $capital     la capital du pays
 * @param string $region      la region du pays
 * @param int    $gnp         le produit national brut du pays
 * @param string $headOfState le chef d'état du pays
 * @param int    $id          l'id du pays
 *                            à modifier
 * 
 * @return commande
 */
function updateContinent($population, $surfaceArea, $capital, $region, $gnp, $headOfState, $id)
{
    global $pdo;
    $query = "update country set Population = :population,SurfaceArea = :surface,Capital = (SELECT city.id from city where city.idCountry = country.id and country.id = :id and city.Name = :Capital),Region = :region, GNP = :gnp, HeadOfState= :headofstate where id=:id1";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':population', $population, PDO::PARAM_INT);
    $prep->bindValue(':surface', $surfaceArea, PDO::PARAM_INT);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':Capital', $capital, PDO::PARAM_STR);
    $prep->bindValue(':region', $region, PDO::PARAM_STR);
    $prep->bindValue(':gnp', $gnp, PDO::PARAM_INT);
    $prep->bindValue(':headofstate', $headOfState, PDO::PARAM_STR);
    $prep->bindValue(':id1', $id, PDO::PARAM_INT);

    $prep->execute();
}

/**
 * Obtenir les informations d'un pays ainsi que de sa capital
 * 
 * @param int $id l'id du pays
 * 
 * @return list d'objets (les informations du pays)
 */
function getPays($id)
{

    global $pdo;
    $query = "SELECT country.*,city.Name FROM country,city where city.id = country.Capital and country.id = :id";

    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Obtenir l'id d'un pays envoyé en paramèmetre
 * 
 * @param string $pays le nom du pays
 *
 * @return list d'objets (l'id du pays)
 */
function idPays($pays)
{

    global $pdo;
    $query = "SELECT id FROM country where Pays = :pays";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':pays', $pays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Modifie les données d'un ville en fonction des différents parametres 
 * 
 * @param string $name       le nom de la ville à modifier                        
 * @param int    $population le nombre d'habitant
 * @param string $district   la région de la ville
 * @param int    $id         l'id de cette ville
 * 
 * @return commande
 */
function updateVille($name, $population, $district, $id)
{
    global $pdo;
    $query = "update city set Name = :name ,Population = :population,District = :district where id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':name', $name, PDO::PARAM_STR);
    $prep->bindValue(':population', $population, PDO::PARAM_INT);
    $prep->bindValue(':district', $district, PDO::PARAM_STR);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
}

/**
 * Vérifie la ville donné en parametre '$Capital' existe dans le pays donné en parametre '$pays'
 * 
 * @param string $capital le nom de la ville
 * @param string $pays    le nom du pays
 * 
 * @return array la ville si elle existe
 */
function villeExistePays($capital, $pays)
{

    global $pdo;
    $query = "SELECT city.* FROM `country`,city where country.id = city.idCountry and city.Name = :capital and country.Pays = :pays";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':capital', $capital, PDO::PARAM_STR);
    $prep->bindValue(':pays', $pays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetchall();
}

/**
 * Retourne les informations d'une ville en fonction de l'id donné en parametre
 *
 * @param int $id l'id de cette ville
 *
 * @return list d'objets (les villes)
 */
function getVilleInfo($id)
{
    global $pdo;
    $query = "SELECT city.* FROM city where city.id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Retourne les informations de toute les villes d'un pays
 *
 * @param string $pays  le nom du pays
 * @param string $tri   filtre l'ordre des données
 * @param string $ordre filtre l'ordre des données
 * 
 * @return array d'objets (les villes)
 */
function getVilleByCountry($pays, $tri, $ordre)
{

    global $pdo;
    $query = "SELECT city.* FROM city,country where city.idCountry = country.id and country.Pays = :pays ORDER BY $tri $ordre";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':pays', $pays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetchall();
}

/**
 * Obtenir le drapeau du pays
 * 
 * @param string $pays le nom du pays

 * @return list d'objets (info du pays)
 */
function getDrapeauCountry($pays)
{

    global $pdo;
    $query = "SELECT * FROM country where Pays = :pays";

    $prep = $pdo->prepare($query);
    $prep->bindValue(':pays', $pays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Permet d'ajouter une nouvelle ville à un pays
 * 
 * @param int    $idCountry  l'id du pays qui aura cette ville
 * @param string $nom        le nom de la ville
 * @param int    $population le nombre d'habitant de cette ville
 * @param string $district   la région de cette
 *                           ville
 * 
 * @return commande 
 */
function ajouterUneVille($idCountry, $nom, $population, $district)
{
    global $pdo;
    $query = "INSERT INTO city (idCountry, Name, District, Population) VALUES (:idcountry,:nom,:district,:populations)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':idcountry', $idCountry, PDO::PARAM_INT);
    $prep->bindValue(':nom', $nom, PDO::PARAM_STR);
    $prep->bindValue(':district', $district, PDO::PARAM_STR);
    $prep->bindValue(':populations', $population, PDO::PARAM_INT);
    $prep->execute();
}

/**
 * Permet de supprimer une ville en fonction de son id
 * 
 * @param int $id l'id de la ville à supprimer
 * 
 * @return commande 
 */
function supprimerUneVille($id)
{
    global $pdo;
    $query = "DELETE from city where city.id = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);

    $prep->execute();
}

/**
 * Obtenir la langue la plus parlée d'un pays
 * 
 * @param string $nomPays le nom du pays
 *
 * @return array d'objets (la langue)
 */
function getLanguePays($nomPays)
{
    global $pdo;
    $query = "SELECT language.Name FROM `countrylanguage`,language,country
    where country.id = countrylanguage.idCountry and countrylanguage.idLanguage = language.id and country.Pays = :pays and countrylanguage.Percentage = 
    (SELECT Max(Percentage) from countrylanguage,country where country.id = countrylanguage.idCountry and country.Pays = :pays2)";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':pays', $nomPays, PDO::PARAM_STR);
    $prep->bindValue(':pays2', $nomPays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Obtenir la capital d'un pays
 * 
 * @param string $nomPays le nom du pays
 *
 * @return list d'objets (la capital)
 */
function getCapital($nomPays)
{
    global $pdo;
    $query = "SELECT city.Name FROM country,city where country.Capital = city.id and country.Pays = :pays";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':pays', $nomPays, PDO::PARAM_STR);
    $prep->execute();

    return $prep->fetch();
}

/**
 * Verifie si le pays situé dans la variable $PaysExiste existe dans la base de données
 * 
 * @param string $paysExiste le nom du pays recherché
 *
 * @return list d'objets (le pays s'il existe)
 */
function paysExiste($paysExiste)
{
    global $pdo;
    $requete = "SELECT * from Country where Pays = :pays";
    $prep = $pdo->prepare($requete);
    $prep->bindValue(':pays', $paysExiste, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetch();
}


/**
 * Permet d'ajouter un nouveau membre dans notre bdd en fonction des parametres envoyés
 * 
 * @param string $nom   le login du nouvel utilisateur
 * @param string $mdp   le mot de passe du nouvel utilisateur
 * @param string $email l'email du nouvel utilisateur
 * @param string $role  le role de ce nouvel utilisateur
 * 
 * @return commande
 */
function ajouterUnUtilisateur($nom, $mdp, $email, $role)
{
    global $pdo;
    $query = "INSERT INTO `membre` (`login`, `MotDePasse`, `Email`, `role`,Date_Creation) VALUES (:nom,:mdp,:email,:role,Now())";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':nom', $nom, PDO::PARAM_STR);
    $prep->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $prep->bindValue(':email', $email, PDO::PARAM_STR);
    $prep->bindValue(':role', $role, PDO::PARAM_STR);
    $prep->execute();
}

/**
 * Permet d'obtenir les informations d'un membre en foncion de son id
 * 
 * @param int $id de ce membre
 *
 * @return array d'objets (les infos du membre)
 */
function getMembre($id)
{
    global $pdo;
    $query = "SELECT * from membre where idmembre = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetchAll();
}

/**
 * Permet de vérifié si le login et le mot de passe existe dans la bdd
 * 
 * @param string $login    le login
 *                         demandé
 * @param string $password le mot de passe demandé
 *
 * @return list d'objets (les infos du membre)
 */
function getAuthentification($login, $password)
{
    global $pdo;
    $query = "SELECT * FROM membre where login= :login and MotDePasse= :password";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':login', $login, PDO::PARAM_STR);
    $prep->bindValue(':password', $password, PDO::PARAM_STR);
    $prep->execute();
    // on vérifie que la requête ne retourne qu'une seule ligne
    if ($prep->rowCount() == 1) {
        $result = $prep->fetch();
        return $result;
    } else {
        return false;
    }
}

/**
 * Permet d'obtenir la liste de tout les élèves présent dans la bdd
 * 
 * @param string $tri   filtre l'ordre des
 *                      données
 * @param string $ordre filtre l'ordre des
 *                      données
 *
 * @return array d'objets (les infos des élèves)
 */
function getEleveInfo($tri, $ordre)
{

    global $pdo;
    $query = "SELECT * from membre where role = 'eleve' order by $tri $ordre ";
    $prep = $pdo->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

/**
 * Permet de suprimmé les informations d'un élëve en fonction de son id
 * 
 * @param int $id l'id de cette élève
 * 
 * @return commande
 */
function suprmMembreEleve($id)
{
    global $pdo;
    $query = "DELETE FROM `membre` WHERE `idmembre` = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
}

/**
 * Permet de modifier les informations d'un élëve en fonction de son id
 * 
 * @param string $login      le nouveau login de ce membre
 * @param string $motDePasse le nouveau mot de passe de ce membre
 * @param string $email      la nouvelle adresse mail de ce membre
 * @param string $role       le nouveau role de ce membre
 * @param int    $id         l'id du membre
 *                           à modifier
 * 
 * @return commande
 */
function updateMembre($login, $motDePasse, $email, $role, $id)
{

    global $pdo;
    $query = "update membre set login = :login,MotDePasse = :motdepasse,Email = :email,role = :role where idmembre= :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':login', $login, PDO::PARAM_STR);
    $prep->bindValue(':motdepasse', $motDePasse, PDO::PARAM_STR);
    $prep->bindValue(':email', $email, PDO::PARAM_STR);
    $prep->bindValue(':role', $role, PDO::PARAM_STR);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
}
