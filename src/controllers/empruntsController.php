<?php
require_once '../src/config/database.php';
require_once '../src/models/Emprunt.php';
require_once '../src/models/Livre.php';
require_once '../src/models/Utilisateur.php';
require_once '../public/emprunts.php';

$db = new Database();
$conn = $db->getConnection();
$empruntModel = new Emprunt($conn);
$livreModel = new Livre($conn);
$utilisateurModel = new Utilisateur($conn);

// Récupérer tous les emprunts actifs
$emprunts = $empruntModel->getAllActive();

// Récupérer tous les livres disponibles
$livres = $livreModel->getAllAvailable();

// Récupérer tous les utilisateurs
$utilisateurs = $utilisateurModel->getAll();

// Ajouter un emprunt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $id_livre = $_POST['id_livre'];
    $id_utilisateur = $_POST['id_utilisateur'];
    $date_retour_prevu = $_POST['date_retour_prevu'];

    // Vérifier si le livre est disponible
    if ($livreModel->isAvailable($id_livre)) {
        // Définir la date d'emprunt comme la date actuelle
        $date_emprunt = date('Y-m-d'); // Date actuelle

        // Créer l'emprunt avec la date d'emprunt et la date de retour prévue
        if ($empruntModel->create($id_livre, $id_utilisateur, $date_emprunt, $date_retour_prevu)) {
            // Marquer le livre comme emprunté
            $livreModel->updateAvailability($id_livre, 0); // Le livre est maintenant emprunté

            header("Location: emprunts.php?success=Emprunt ajouté avec succès");
            exit;
        } else {
            header("Location: emprunts.php?error=Erreur lors de l'emprunt");
            exit;
        }
    } else {
        header("Location: emprunts.php?error=Le livre est déjà emprunté");
        exit;
    }
}

// Retourner un livre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'return') {
    $id_emprunt = $_POST['id_emprunt'];

    if ($empruntModel->returnBook($id_emprunt)) {
        // Récupérer l'id du livre
        $id_livre = $empruntModel->getBookIdByEmprunt($id_emprunt);

        // Marquer le livre comme disponible
        $livreModel->updateAvailability($id_livre, 1); // Le livre est maintenant disponible

        header("Location: emprunts.php?success=Livre retourné avec succès");
        exit;
    } else {
        header("Location: emprunts.php?error=Erreur lors du retour du livre");
        exit;
    }
}
?>
