<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once __DIR__ . '/../php/connectBdd.php';

$user_id = $_SESSION['user_id'];

// Requête pour récupérer les informations d'historique
$sql = "SELECT 
            hr.date_reponse, 
            qn.nom_questionnaire, 
            q.libelle, 
            hr.reponse,
            q.bonne_reponse 
        FROM historique_reponses hr 
        JOIN questionnaire qn ON hr.id_questionnaire = qn.id_questionnaire 
        JOIN question q ON hr.id_question = q.id_question 
        WHERE hr.id_utilisateur = :user_id 
        ORDER BY hr.date_reponse DESC";

$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Quizz</title>
    <link rel="stylesheet" href="../css/styleHistorique.css">
</head>
<body>
   
    <h1>Historique de vos réponses</h1>
    <?php if(count($historique) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Questionnaire</th>
                    <th>Question</th>
                    <th>Votre réponse</th>
                    <th>Boone réponse</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($historique as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date_reponse']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom_questionnaire']); ?></td>
                        <td><?php echo htmlspecialchars($row['libelle']); ?></td>
                        <td><?php echo htmlspecialchars($row['reponse']); ?></td>
                        <td><?php echo htmlspecialchars($row['bonne_reponse']);?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun historique disponible.</p>
    <?php endif; ?>
</body>
</html>
