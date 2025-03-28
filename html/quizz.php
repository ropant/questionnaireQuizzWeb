<?php
session_start();
include_once __DIR__ . '/../php/connectBdd.php';

// Traitement du formulaire si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID du questionnaire depuis POST
    if (isset($_POST['questionnaire_id'])) {
        $questionnaire_id = $_POST['questionnaire_id'];
    } else {
        echo "Questionnaire non spécifié.";
        exit;
    }
    
    if (!isset($_SESSION["user_id"])) {
        echo "Vous devez être connecté pour enregistrer vos réponses.";
        exit;
    }
    $user_id = $_SESSION["user_id"];
    
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
    exit(); // Arrêtez l'exécution pour éviter d'afficher le formulaire à nouveau
}

// Affichage du formulaire : récupérez l'ID du questionnaire depuis GET ou depuis la session
if (isset($_GET['questionnaire_id'])) {
    $questionnaireId = $_GET['questionnaire_id'];
    $_SESSION['questionnaire_id'] = $questionnaireId;
} elseif (isset($_SESSION['questionnaire_id'])) {
    $questionnaireId = $_SESSION['questionnaire_id'];
} else {
    echo "Aucun questionnaire sélectionné.";
    exit();
}

// Récupérer les questions du questionnaire
$sql = "SELECT * FROM question WHERE id_questionnaire = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $questionnaireId, PDO::PARAM_INT);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/stylequizz.css">
    <title>Quiz</title>
</head>
<body>
<header>
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['identifiant']); ?></p>
    </header>
    <h1>Questions du questionnaire</h1>
    <!-- Le formulaire utilise la méthode POST et pointe vers ce même fichier -->
    <form id="quiz-form" method="POST" action="quizz.php">
        <!-- Champ caché pour transmettre l'ID du questionnaire -->
        <input type="hidden" name="questionnaire_id" value="<?php echo htmlspecialchars($questionnaireId); ?>">
        <ul id="questions">
            <?php
            foreach ($questions as $question) {
                echo '<li class="question" data-correct-answer="' . htmlspecialchars($question['bonne_reponse']) . '">';
                echo '<p>' . htmlspecialchars($question['libelle']) . '</p>';
                echo '<ul class="reponses">';
                echo '<li><input type="radio" name="question-' . $question['id_question'] . '" value="' . htmlspecialchars($question['rep1']) . '"> ' . htmlspecialchars($question['rep1']) . '</li>';
                echo '<li><input type="radio" name="question-' . $question['id_question'] . '" value="' . htmlspecialchars($question['rep2']) . '"> ' . htmlspecialchars($question['rep2']) . '</li>';
                echo '<li><input type="radio" name="question-' . $question['id_question'] . '" value="' . htmlspecialchars($question['rep3']) . '"> ' . htmlspecialchars($question['rep3']) . '</li>';
                echo '<li><input type="radio" name="question-' . $question['id_question'] . '" value="' . htmlspecialchars($question['bonne_reponse']) . '"> ' . htmlspecialchars($question['bonne_reponse']) . '</li>';
                echo '</ul>';
                echo '</li>';
            }
            ?>
        </ul>
        <button type="submit" onclick="validerQuiz()">Valider</button>
    </form>
    <div id="resultat"></div>
    <script>
        function validerQuiz() {
            // On peut calculer le score côté client pour affichage en console
            const questions = document.querySelectorAll('#questions > li.question');
            let score = 0;
            questions.forEach((question, index) => {
                const correctAnswer = question.getAttribute('data-correct-answer');
                const radios = question.querySelectorAll('input[type="radio"]');
                let selectedAnswer = null;
                radios.forEach((radio) => {
                    if (radio.checked) {
                        selectedAnswer = radio.value;
                    }
                });
                console.log(`Question ${index + 1}: Réponse sélectionnée = ${selectedAnswer}, Bonne réponse = ${correctAnswer}`);
                if (selectedAnswer === correctAnswer) {
                    score++;
                }
            });
            // Vous pouvez afficher le score si besoin
            document.getElementById('resultat').innerText = 'Votre score est : ' + score + '/' + questions.length;
        }
    </script>
</body>
</html>
