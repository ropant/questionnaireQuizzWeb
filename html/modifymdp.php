<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modification du mot de passe</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styleConnexion.css">
</head>
<body>
    <div class="formulaire">
        <form action="/projetPHP/php/newMDP.php" method="POST">
            <div class="head-formulaire">
                <h1>Modifiez votre mot de passe</h1>
            </div>
            <br>

            <div id="div_identifiant">
                <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant" required>
            </div>
            <br>

            <div id="div_mdp">
                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe actuel" required>
            </div>
            <br>

            <div id="div_new_mdp">
                <input type="password" id="new_mdp" name="new_mdp" placeholder="Nouveau mot de passe" required>
            </div>
            <br>

            <button type="submit">Créer un nouveau mot de passe</button>
            <br>

            <a id="create_account" href="createAccount.php">Créer un compte</a>
            <br>

            <a id="forgot_password" href="forgotMDP.php">Mot de passe oublié</a>
        </form>
    </div>
</body>
</html>
