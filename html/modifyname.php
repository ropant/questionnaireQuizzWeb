<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modification du nom de l'utilisateur</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styleConnexion.css">
</head>
<body>
    <div class="formulaire">
        <form action="/projetPHP/php/newName.php" method="POST">
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
                <input type="text" id="new_name" name="new_name" placeholder="Nouveau nom d'utilisateur" required>
            </div>
            <br>

            <button type="submit">Créer un nouveau nom d'utilisateur</button>
            <br>

           
        </form>
    </div>
</body>
</html>
