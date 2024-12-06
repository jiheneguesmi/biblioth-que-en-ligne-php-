<?php
require_once '../src/config/database.php';
require_once '../src/models/Utilisateur.php';

$db = new Database();
$conn = $db->getConnection();
$utilisateurModel = new Utilisateur($conn);

// Récupérer tous les utilisateurs
$utilisateurs = $utilisateurModel->getAll();

// Ajouter un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'];

    if ($utilisateurModel->checkIfExists($email)) {
        header("Location: utilisateurs.php?error=L'email existe déjà.");
        exit;
    }

    if ($utilisateurModel->create($nom, $email, $mot_de_passe, $role)) {
        header("Location: utilisateurs.php?success=Utilisateur ajouté avec succès");
        exit;
    } else {
        header("Location: utilisateurs.php?error=Erreur lors de l'ajout de l'utilisateur");
        exit;
    }
}

// Modifier un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : null; // Mot de passe optionnel

    if ($utilisateurModel->update($id, $nom, $email, $role, $mot_de_passe)) {
        header("Location: utilisateurs.php?success=Utilisateur modifié avec succès");
        exit;
    } else {
        header("Location: utilisateurs.php?error=Erreur lors de la modification de l'utilisateur");
        exit;
    }
}

// Supprimer un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    if ($utilisateurModel->delete($id)) {
        header("Location: utilisateurs.php?success=Utilisateur supprimé avec succès");
        exit;
    } else {
        header("Location: utilisateurs.php?error=Erreur lors de la suppression de l'utilisateur");
        exit;
    }
}
?>
