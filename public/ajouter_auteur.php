<?php
session_start();
require_once '../src/config/database.php';
require_once '../src/models/Auteur.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Rediriger vers la page de login si non connecté
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $biographie = $_POST['biographie'];
    $photo = $_FILES['photo'];

    // Validation du fichier image
    $photoPath = '';
    if ($photo && $photo['error'] == 0) {
        $photoPath = 'uploads/' . basename($photo['name']);
        move_uploaded_file($photo['tmp_name'], '../public/' . $photoPath);
    }

    // Connexion à la base de données
    $db = new Database();
    $conn = $db->getConnection();
    $auteurModel = new Auteur($conn);

    // Ajouter l'auteur dans la base de données
    if ($auteurModel->create($nom, $prenom, $biographie, $photoPath)) {
        header("Location: auteurs.php?success=L'auteur a été ajouté avec succès.");
    } else {
        echo "Erreur lors de l'ajout de l'auteur.";
    }
}
?>
