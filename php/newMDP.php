<?php
include_once __DIR__ . '/connectBdd.php'; // Inclusion de la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $identifiant = trim($_POST["identifiant"]);
    $ancien_mdp = trim($_POST["mdp"]);
    $nouveau_mdp = trim($_POST["new_mdp"]);

    // Vérifier si les champs sont remplis
    if (empty($identifiant) || empty($ancien_mdp) || empty($nouveau_mdp)) {
        die("Tous les champs sont obligatoires.");
    }

    // Préparer une requête pour vérifier l'identifiant et l'ancien mot de passe
    $stmt = $db->prepare("SELECT mot_passe_utilisateur FROM utilisateur WHERE nom_utilisateur = :identifiant");
    $stmt->bindParam(":identifiant", $identifiant);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        // Vérifier si l'ancien mot de passe correspond
        if (password_verify($ancien_mdp, $result['mot_passe_utilisateur'])) {
            // Hacher le nouveau mot de passe
            $nouveau_mdp_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe
            $stmt = $db->prepare("UPDATE utilisateur SET mot_passe_utilisateur = :nouveau_mdp WHERE nom_utilisateur = :identifiant");
            $stmt->bindParam(":nouveau_mdp", $nouveau_mdp_hash);
            $stmt->bindParam(":identifiant", $identifiant);

            if ($stmt->execute()) {
                echo "Mot de passe mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du mot de passe : " . $stmt->errorInfo()[2];
            }
        } else {
            echo "L'ancien mot de passe est incorrect.";
        }
    } else {
        echo "Identifiant non trouvé.";
    }
}
?>
