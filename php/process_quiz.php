<?php
session_start();
include_once __DIR__ . '/../php/connectBdd.php';

if (!isset($_SESSION["user_id"])) {
    echo "Vous devez être connecté pour enregistrer vos réponses.";
    exit;
}

$user_id = $_SESSION["user_id"];

// Récupérer l'ID du questionnaire depuis POST
if (isset($_POST['questionnaire_id'])) {
    $questionnaire_id = $_POST['questionnaire_id'];
} else {
    echo "Questionnaire non spécifié.";
    exit;
}

// Parcourir toutes les données postées pour enregistrer les réponses
foreach ($_POST as $key => $value) {
    if (strpos($key, 'question-') === 0) {
        $question_id = str_replace('question-', '', $key);
        $selected_answer = $value;

        $stmt = $db->prepare("INSERT INTO historique_reponses (id_utilisateur, id_questionnaire, id_question, reponse, date_reponse) VALUES (:id_utilisateur, :id_questionnaire, :id_question, :reponse, NOW())");
        $stmt->bindParam(':id_utilisateur', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_questionnaire', $questionnaire_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_question', $question_id, PDO::PARAM_INT);
        $stmt->bindParam(':reponse', $selected_answer, PDO::PARAM_STR);
        $stmt->execute();
    }
}

echo "Vos réponses ont été enregistrées avec succès.";
?>
