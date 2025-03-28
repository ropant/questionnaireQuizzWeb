<?php
include_once __DIR__ . '/connectBdd.php'; // Inclusion de la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $mdp = trim($_POST["mdp"]);
    $mdp_confirmation = trim($_POST["mdp_confirmation"]);
    $email = trim($_POST["email"]);

    if (empty($identifiant) || empty($mdp) || empty($mdp_confirmation) ||empty($email)) {
        echo' <div id="div-message">';

        echo'<p>Tous les champs sont obligatoires.</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
        
    }
    if (strlen($mdp) < 7 || !caracterespeciaux($mdp)) {
        echo' <div id="div-message">';

        echo'<p>Le mot de passe doit être supérieur à 7 caractères et contenir au moins un caractère spécial</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
        
    }

    if ($mdp !== $mdp_confirmation) {
        
        echo' <div id="div-message">';

        echo'<p>Les mots de passe ne correspondent pas</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
        
    }

    // Vérifier si l'identifiant existe déjà
    $stmt = $db->prepare("SELECT id_utilisateur FROM utilisateur WHERE nom_utilisateur = :identifiant");
    $stmt->bindParam(":identifiant", $identifiant);
    $stmt->execute();

    if ($stmt->fetch()) {
       
        echo' <div id="div-message">';

        echo'<p>Cet identifiant est déjà utilisé</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
    }

    // Hachage sécurisé du mot de passe
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la base de données
    $stmt = $db->prepare("INSERT INTO utilisateur (nom_utilisateur, mot_passe_utilisateur, email) VALUES (:identifiant, :mdp, :email)");
    $stmt->bindParam(":identifiant", $identifiant);
    $stmt->bindParam(":mdp", $mdp_hash);
    $stmt->bindParam(":email",$email);

    if ($stmt->execute()) {
        session_start();
        $_SESSION["user_id"] = $db->lastInsertId();
        $_SESSION["identifiant"] = $identifiant;
        header("Location: ../html/themes.php"); // Redirection après inscription
        exit();
    } else {
        
         echo' <div id="div-message">';

        echo'<p>Erreur inscription</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
    }
}

function caracterespeciaux($mdp){
    $caractèrespeciaux='&~"#{([-|`_\^@=+}$%*!§:/;.,?';
    for ($i = 0; $i < strlen($mdp); $i++){
        if (strpos($caractèrespeciaux, $mdp[$i]) !== false) {
            return true;
        }
    }
    return false;

};

?>
