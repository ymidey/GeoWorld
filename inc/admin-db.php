<?php

/**
 * Ce script est composé de fonctions d'exploitation des données
 * détenues par le SGBDR MySQL utilisées par la logique de l'application pour l'administrateur
 *
 * C'est le seul endroit dans l'application où a lieu la communication entre
 * la logique métier de l'application et les données en base de données, que
 * ce soit en lecture ou en écriture.
 * 
 *  PHP version 7
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
 * Permet d'obtenir la liste de tout les membres présent 
 * dans la table membre de la bdd 
 * 
 * @param string $tri   filtre l'ordre des données
 * @param string $ordre filtre l'ordre des données
 * 
 * @return array d'objets (les infos des élèves)
 */
function getMembre($tri, $ordre)
{
    global $pdo;
    $query = "SELECT * from membre order by $tri $ordre ";
    return $pdo->query($query)->fetchAll();
}

/**
 * Permet de suprimmé les informations d'un membre en fonction de son id
 *
 * @param int $id id de l'élève 
 * 
 * @return commande
 */
function suprmMembre($id)
{
    global $pdo;
    $query = "DELETE FROM `membre` WHERE `idmembre` = :id";
    $prep = $pdo->prepare($query);

    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();
}

/**
 * Permet de récuper toute les informations d'un membre en fonction de son id
 *
 * @param int $id id de l'élève 
 * 
 * @return list liste d'objets (les informations du membre)
 */
function getMembreModif($id)
{
    global $pdo;
    $query = "SELECT * from membre where idmembre = :id";
    $prep = $pdo->prepare($query);

    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->execute();

    return $prep->fetch();
}


/**
 * Permet de modifier les informations d'un membre en fonction de son id
 *
 * @param string $login      login de l'élève
 * @param string $motDePasse mot de passe de l'élève
 * @param string $email      email de l'élève
 * @param string $role       role de l'élève
 * @param int    $id         id de l'élève
 * 
 * @return commande
 */
function updateMembre($login, $motDePasse, $email, $role, $id)
{

    global $pdo;
    $query = "update membre set login = :login,MotDePasse = :mdp,Email = :email,role = :role where idmembre = :id";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':login', $login, PDO::PARAM_STR);
    $prep->bindValue(':mdp', $motDePasse, PDO::PARAM_STR);
    $prep->bindValue(':email', $email, PDO::PARAM_STR);
    $prep->bindValue(':role', $role, PDO::PARAM_STR);
    $prep->bindValue(':id', $id, PDO::PARAM_INT);

    $prep->execute();
}
