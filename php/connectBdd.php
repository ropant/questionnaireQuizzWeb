<?php
$user='root';
$password ='';


try {
    $db = new PDO("mysql:host=localhost;dbname=questionnaire", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active les erreurs PDO
   // echo "Connexion réussie !"; // Vérification
    
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage(); // Affiche l'erreur
}

?>

