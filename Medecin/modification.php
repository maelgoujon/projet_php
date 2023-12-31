<!DOCTYPE HTML>
<html>
<head>

<?php

      session_start();

      // Vérifier si l'utilisateur est authentifié
      if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
          header("Location: /Projet/projet_php/Base/login.php");
          exit();
      }
      include '../Base/header.php';

    ?>
    <title>Modification d'un medecin</title>
</head>
<body>
    <div class="container">
        <?php
        $server = 'localhost';
        $db = 'php_project';
        $login = "etu";
        $mdp = "\$iutinfo";

        $validationMessage = '';

        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $idMedecin = $_POST['idMedecin'];
                $civilite = $_POST['civilite'];
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];

                // Requête SQL de mise à jour
                $sql = "UPDATE medecin SET Civilite=?, Prenom=?, Nom=? WHERE idMedecin=?";

                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }

                $test = $stmt->execute([$civilite, $prenom, $nom, $idMedecin]);

                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }
                // Vérification de la mise à jour
                if ($stmt->rowCount() > 0) {
                    $validationMessage = "Les informations du medecin ont ete modifiees avec succes.";
                } else {
                    $validationMessage = "Aucune modification effectuée pour le medecin.";
                } 

            } else {

                // Récupération de l'ID du medecin à partir de la requête GET
                if (isset($_GET['id'])) {
                    $idMedecin = $_GET['id'];

                    // Requête SQL pour récupérer les informations du medecin
                    $sql = "SELECT * FROM medecin WHERE idMedecin=?";
                    $stmt = $linkpdo->prepare($sql);
                    $stmt->execute([$idMedecin]);
                    $medecin = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
        ?>


        <form method="post" action="modification.php">
          <h1>Modification d'un medecin</h1>
          <?php
            if ($stmt->rowCount() > 0) {
                echo '<p style="color: green;">' . $validationMessage . '</p>';
                ?>
                <form method="post" action="modification.php">
                    <!-- Ajouter les valeurs par défaut dans les champs -->
                    <input type="hidden" name="idMedecin" value="<?php echo isset($medecin['idMedecin']) ? $medecin['idMedecin'] : ''; ?>">
                    <label for="civilite">Civilité:</label>
                    <input type="text" name="civilite" value="<?php echo isset($medecin['Civilite']) ? $medecin['Civilite'] : ''; ?>"><br>

                    <label for="prenom">Prénom:</label>
                    <input type="text" name="prenom" value="<?php echo isset($medecin['Prenom']) ? $medecin['Prenom'] : ''; ?>"><br>

                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" value="<?php echo isset($medecin['Nom']) ? $medecin['Nom'] : ''; ?>"><br>

                    <input type="button" value="Retour" onclick="history.back()">
                    <input type="submit" value="Modifier le medecin">
                    <a href="/../Projet/projet_php/index.php">
                        <input type="button" value="Accueil">
                    </a>
                </form>
            <?php
            } else {
                echo "Medecin non trouve.";
            }
            ?>

        </form>

        
    </div>
</body>
</html>
