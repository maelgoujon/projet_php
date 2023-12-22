<?php

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Projet/projet_php/Base/login.php");
    exit();
}

include '../Base/header.php';

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=DM+Sans:500,700&display=swap");

* {
  box-sizing: border-box;
}

.body {
  text-align: center;
  height: 100vh;
  width: 100%;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
}

.nav {
  display: inline-flex;
  position: relative;
  overflow: hidden;
  max-width: 100%;
  background-color: #fff;
  padding: 0 20px;
  border-radius: 40px;
  box-shadow: 0 10px 40px rgba(159, 162, 177, 0.8);
}

.nav-item {
  color: #83818c;
  padding: 20px;
  text-decoration: none;
  transition: 0.3s;
  margin: 0 6px;
  z-index: 1;
  font-family: "DM Sans", sans-serif;
  font-weight: 500;
  position: relative;
}

.nav-item:before {
  content: "";
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 100%;
  height: 5px;
  border-radius: 8px 8px 0 0;
  opacity: 0;
  transition: 0.3s;
}

.nav-item.is-active:before {
  background-color: orange; /* couleur spéciale pour Accueil */
}

.nav-item.is-active:hover:before {
  opacity: 0; /* désactiver la barre lorsque le lien actif est survolé */
}

.nav-item:not(.is-active):hover:before,
.nav-item:first-child:hover:before {
  opacity: 1;
  bottom: 0;
}

.nav-item:nth-child(2):before {
  background-color: green; /* couleur spéciale pour A propos */
}

.nav-item:nth-child(3):before {
  background-color: blue; /* couleur spéciale pour Liste */
}

.nav-item:nth-child(4):before {
  background-color: red; /* couleur spéciale pour Blog */
}

.nav-item:nth-child(5):before {
  background-color: rebeccapurple; /* couleur spéciale pour Contact */
}

.nav-item:nth-child(6):before {
  background-color: pink; /* couleur spéciale pour Contact */
}

@media (max-width: 580px) {
  .nav {
    overflow: auto;
  }
}

/* Ajoutez ces styles à votre fichier css.css */

.body {
  text-align: center;
    }  

    .nav {
    display: flex;
    background-color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Ajout d'une marge en bas pour séparer la barre de navigation du contenu */
    }

    .nav-item {
    color: #83818c;
    padding: 10px;
    text-decoration: none;
    transition: 0.3s;
    margin: 0 6px;
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    position: relative;
    }

    .nav-item:before {
    content: "";
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 100%;
    height: 3px;
    border-radius: 4px 4px 0 0;
    opacity: 0;
    transition: 0.3s;
    }

    .nav-item.is-active:before {
    background-color: orange;
    }

    .nav-item.is-active:hover:before {
    opacity: 0;
    }

    .nav-item:not(.is-active):hover:before,
    .nav-item:first-child:hover:before {
    opacity: 1;
    bottom: 0;
    }

    /* Ajoutez un style pour le tableau */
    table {
    width: 100%;
    margin-top: 20px; /* Ajout d'une marge en haut du tableau */
    }

    th,
    td {
    padding: 10px;
    text-align: center;
    }

    th {
    background-color: #f2f2f2;
    }

    /* Ajoutez un style pour le titre du tableau */
    h2 {
    margin-top: 20px; /* Ajout d'une marge en haut du titre */
    }

    </style>
  </head>

    <body>

    


    <?php
    include '../Base/config.php';

// Requête pour récupérer tous les patients avec le nom du médecin référent
$sql = "SELECT p.idPatient, p.Civilite, p.Prenom, p.Nom, p.Adresse, p.Date_de_naissance, p.Lieu_de_naissance, p.Numero_Securite_Sociale, m.Nom AS NomMedecin, m.Prenom AS PrenomMedecin
        FROM Patient p
        LEFT JOIN Medecin m ON p.idMedecin = m.idMedecin";

$result = $conn->query($sql);

// Affichage des patients dans un tableau HTML
echo "<h2>Liste des patients</h2>";
echo "<table border='1'>
    <tr>
        <th>Civilité</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Date de Naissance</th>
        <th>Lieu de Naissance</th>
        <th>Numéro Sécurité Sociale</th>
        <th>Médecin Référent</th>
        <th>Action</th>
    </tr>";

while ($row = $result->fetch_assoc()) {
    $civilite = ($row['Civilite'] == 1) ? 'Monsieur' : 'Madame';
    echo "<tr>
        <td>{$civilite}</td>
        <td>{$row['Prenom']}</td>
        <td>{$row['Nom']}</td>
        <td>{$row['Adresse']}</td>
        <td>{$row['Date_de_naissance']}</td>
        <td>{$row['Lieu_de_naissance']}</td>
        <td>{$row['Numero_Securite_Sociale']}</td>
        <td>{$row['NomMedecin']} {$row['PrenomMedecin']}</td>
        <td><a href='modification.php?id={$row['idPatient']}'>Modifier</a> | <a href='suppression.php?id={$row['idPatient']}'>Supprimer</a></td>
    </tr>";
}

echo "</table>";

// Fermer la connexion
$conn->close();
?>

<html>
    <a href="ajoutcontact.php">
        <input type="button" value="Ajouter un patient">
    </a>
</html>