<?php
    include_once __DIR__ . '/../php/connectBdd.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page de Connexion</title>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="../css/styleConnexion.css">
    <script src="/java/script.js" async></script>
</head>
<body>
    <div class="formulaire">
        <form action="/projetPHP/php/login.php" method="POST">
            <div class="head-formulaire">
                <h1>Bonjour! Veuillez vous connecter</h1>
            </div>
            <br>

            <div class="input">
                <div id="div_identifiant">
                    <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant" required>
                </div>
                <br>

                <div id="div_mdp">
                    <input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required>
                </div>
                <br>

               
                <br>

                <button type="submit">Me connecter</button>
                <br>

                <a id="create account" href="createAccount.php">créer un compte</a>
                <br>

               

            </div>
        </form>
    </div>
</body>
</html>
