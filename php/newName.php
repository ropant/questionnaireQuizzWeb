<?php
include_once __DIR__ . '/connectBdd.php'; // Inclusion de la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $identifiant = trim($_POST["identifiant"]);
    $mdp = trim($_POST["mdp"]);
    $new_name = trim($_POST["new_name"]);

    // Vérifier si les champs sont remplis
    if (empty($identifiant) || empty($mdp) || empty($new_name)) {
        die("Tous les champs sont obligatoires.");
    }

    // Préparer une requête pour vérifier l'identifiant et le mot de passe
    $stmt = $db->prepare("SELECT mot_passe_utilisateur FROM utilisateur WHERE nom_utilisateur = :identifiant");
    $stmt->bindParam(":identifiant", $identifiant);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        // Vérifier si le mot de passe correspond
        if (password_verify($mdp, $result['mot_passe_utilisateur'])) {
            // Vérifier si le nouveau nom d'utilisateur est déjà utilisé
            $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateur WHERE nom_utilisateur = :new_name");
            $stmt->bindParam(":new_name", $new_name);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                die("Ce nom d'utilisateur est déjà utilisé.");
            }

            // Mettre à jour le nom d'utilisateur
            $stmt = $db->prepare("UPDATE utilisateur SET nom_utilisateur = :new_name WHERE nom_utilisateur = :identifiant");
            $stmt->bindParam(":new_name", $new_name);
            $stmt->bindParam(":identifiant", $identifiant);

            if ($stmt->execute()) {
                echo "Nom d'utilisateur mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du nom d'utilisateur : " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Le mot de passe est incorrect.";
        }
    } else {
        echo "Identifiant non trouvé.";
    }
}
?>
