<?php
include_once __DIR__ . '/connectBdd.php';

// Vérifiez que $pdo est bien défini
if (!isset($db)) {
    die("La connexion à la base de données n'a pas été établie.");
}

// Requête SQL
$sql = "SELECT * FROM questionnaire WHERE id_theme = 1";

$stmt = $db->prepare($sql);
$stmt->execute();

$questionnaire = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enregistrement des résultats dans les logs
error_log(print_r($questionnaire, true));

// Optionnel : Affichage des résultats dans le navigateur pour vérification
echo '<pre>';
print_r($questionnaire);
echo '</pre>';
?>
