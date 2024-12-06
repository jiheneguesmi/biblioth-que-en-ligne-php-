<?php
require_once '../src/config/database.php';
require_once '../src/models/Livre.php';
require_once '../src/models/Auteur.php';

$db = new Database();
$conn = $db->getConnection();
$livreModel = new Livre($conn);
$auteurModel = new Auteur($conn);

// Récupérer tous les livres
$livres = $livreModel->getAll();
// Vérification du contenu des livres
if ($livres === false) {
    echo "Aucun livre trouvé dans la base de données.";
}
// Récupérer tous les auteurs pour afficher dans le formulaire d'ajout de livre
$auteurs = $auteurModel->getAll();

// Ajouter un livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $titre = $_POST['titre'];
    $genre = $_POST['genre'];
    $auteur_id = $_POST['auteur_id'];
    $disponibilite = $_POST['disponibilite'];

    // Créer le livre
    if ($livreModel->create($titre, $genre, $auteur_id, $disponibilite)) {
        header("Location: livres.php?success=Livre ajouté avec succès");
        exit;
    } else {
        header("Location: livres.php?error=Erreur lors de l'ajout du livre");
        exit;
    }
}

// Modifier un livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $genre = $_POST['genre'];
    $auteur_id = $_POST['auteur_id'];
    $disponibilite = $_POST['disponibilite'];

    // Mettre à jour le livre
    if ($livreModel->update($id, $titre, $genre, $auteur_id, $disponibilite)) {
        header("Location: livres.php?success=Livre modifié avec succès");
        exit;
    } else {
        header("Location: livres.php?error=Erreur lors de la modification du livre");
        exit;
    }
}

// Supprimer un livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    if ($livreModel->delete($id)) {
        header("Location: livres.php?success=Livre supprimé avec succès");
        exit;
    } else {
        header("Location: livres.php?error=Erreur lors de la suppression du livre");
        exit;
    }
}
?>
