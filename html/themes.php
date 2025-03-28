<?php 
include_once __DIR__ . '/../php/connectBdd.php';
session_start();
if(isset($_SESSION["user_id"])){
    //echo "Bienvenue, " . htmlspecialchars($_SESSION["identifiant"]);

}else {
    header("Location: /projetPHP/html/login.php");
    exit();
}

$sql="SELECT * From theme;";
$request = $db ->prepare($sql);
$request -> execute();
$themes = $request -> fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Page des thèmes</title>
    <meta charset="UTF-8">
   <link rel="stylesheet" href="../css/themecss.css">
    <script src="../java/script.js" defer></script>
</head>
<body>
<header>
    <ul class="header">
        <li>Afficher les questions</li>
        <li>Créer des questions</li>
        <li>Créer un questionnaire</li>
        <li id="compte_utilisateur">
            Espace Utilisateur
            <ul class="menu-deroulant">
                <li><a href="modifyname.php">Modifier mon nom d'utilisateur</a></li>
                <li><a href="modifymdp.php">Modifier mon mot de passe</a></li>
                <li><a href="historique.php">Historique des quizz</a></li>
                <li><a href="formulaire.php">Se déconnecter</a></li>
               
            </ul>
        </li>
    </ul>
</header>
<div class="theme-liste">
    <div class="theme">
        <p id="question">Choisissez un thème!</p>
        <ul>
            <?php
            foreach($themes as $theme){
                echo '<li id="theme-'.htmlspecialchars($theme['nom']).'class="id-theme>';
                echo '<a href="questionnaireHistoire.php?theme='. htmlspecialchars($theme['id_theme']).'">'. htmlspecialchars($theme['nom']).'</a>';
                echo'</li>';
            }
            ?>
        
        </ul>
    </div>
</div>

<script src="../js/script.js"></script>
</body>
</html>
