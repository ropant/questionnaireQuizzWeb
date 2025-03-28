<?php
include_once __DIR__ . '/../php/connectBdd.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Création du compte</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styleConnexion.css">
</head>
<body>
    
    <div class="formulaire">
        <form action="/projetPHP/php/register.php" method="POST">
            <div class="head-formulaire">            
                <h1>Bonjour! Veuillez créer un mot de passe</h1>
            </div>

        
            <div id="div_identifiant">
                <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant" required>
            </div>
            <br>

            <div id="div_email">
                <input type="text" id="email" name="email" placeholder="email" required>
            </div>
            <br>

            <div id="div_mdp">
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>
            <br>
            <br>
                <input type="password" id="mdp_confirmation" name="mdp_confirmation" placeholder="Confirmer le mot de passe" required>
            </div>
                
                <button type="submit">Créer mon compte</button>
        </form>
            <p>Déjà un compte ? <a href="formulaire.php">Se connecter</a></p>
    </div>
</body>
</html>

