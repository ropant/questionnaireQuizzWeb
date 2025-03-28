<?php
include_once __DIR__ . '/connectBdd.php'; // Inclusion de la connexion à la base de données
session_start();
echo '<link rel="stylesheet" href="../css/styleConnexion.css">';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $mdp = trim($_POST["mdp"]);

    if (!empty($identifiant) && !empty($mdp)) {
        // Vérifier si l'utilisateur existe
        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE nom_utilisateur = :identifiant");
        $stmt->bindParam(":identifiant", $identifiant);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($mdp, $user["mot_passe_utilisateur"])) { // Vérification sécurisée
                
                $_SESSION["user_id"] = $user["id_utilisateur"];
                $_SESSION["identifiant"] = $user["nom_utilisateur"];

               // header("Location: /projetPHP/html/themes.php?username=" . urlencode($user["nom_utilisateur"]));
               header("Location: /projetPHP/html/themes.php"); 
               exit();
            } else {
                echo' <div id="div-message">';

                echo'<p>Impossible de se connecter identifiant ou mot de passe incorrecte</p>';
                echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
            
            
               echo '</div>' ;
            }
        } else {
            echo' <div id="div-message">';

            echo'<p>Identifiant introuvable.</p>';
            echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
        
        
           echo '</div>' ;
            
        }
    } else {
        echo' <div id="div-message">';

        echo'<p>Veuillez remplir tout les champs</p>';
        echo'<a href="../html/formulaire.php">Veuillez réessayer</a>';
    
    
       echo '</div>' ;
    }
}
?>
