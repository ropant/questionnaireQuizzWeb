<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once __DIR__ . '/../php/connectBdd.php';
if (!isset($db)) {
    echo "La connexion à la base de données a échoué";
    exit;
}
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'];
     // Optionnel : on peut enregistrer l'id du thème dans la session
     $_SESSION['theme'] = $theme;
} else {
    echo "Aucun thème sélectionné.";
    exit;
}

$sql = "SELECT * FROM questionnaire WHERE id_theme = :id_theme";

$stmt = $db->prepare($sql);
$stmt->bindParam(':id_theme', $theme, PDO::PARAM_INT);
$stmt->execute();

$questionnaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/styleQuestionnaire.css">
    <title>Choisissez un questionnaire</title>
</head>
<body>
    <ul id="questionnaire">
        <?php
        foreach ($questionnaires as $questionnaire) {
            
            echo '<li id="' . htmlspecialchars($questionnaire['id_questionnaire']) . '">';
            echo '<a href="quizz.php?questionnaire_id=' . htmlspecialchars($questionnaire['id_questionnaire']) . '">' . htmlspecialchars($questionnaire['nom_questionnaire']) . '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</body>
</html>
