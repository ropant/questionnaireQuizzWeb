<?php
include_once __DIR__ . '/../php/connectBdd.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Réinitialisation de votre mot de passe</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/style.css">


    </head>
    <body>
        <div class="formulaire">
             <form action="/php/newMDP.php" method="POST">
            <div id="newMdpFormulaire">
                <h1>Veuillez réinitialiser votre mot de passe</h1>

            <div>
            <input type="password" id="reinitialiser"  name="réinitialyser mot de passe" placeholder="réinitialiser mot de passe">

            </div>
            <div>    
                <input type="password" id="newPassword" name="new password" placeholder="new password" required>
            </div>
                <input type="password" id="confirmNewPassword" name="confirm new password" placeholder="confirm new password" required>
            </div>

            </form>
        </div>
        

    </body>
</html>
