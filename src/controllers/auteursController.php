<?php
require_once '../src/config/database.php';
require_once '../src/models/Auteur.php';

// Initialisation de la base de données et du modèle Auteur
$db = new Database();
$conn = $db->getConnection();
$auteurModel = new Auteur($conn);

// Fonction pour générer une image avec les initiales
function generateInitialImage($nom, $prenom, $destination) {
    $initials = strtoupper($nom[0] . $prenom[0]); // Obtenir les initiales (ex: "JD" pour Jean Dupont)

    // Dimensions de l'image
    $width = 200;
    $height = 200;

    // Créer une image
    $image = imagecreatetruecolor($width, $height);

    // Couleur de fond grise
    $gray = imagecolorallocate($image, 200, 200, 200);
    imagefilledrectangle($image, 0, 0, $width, $height, $gray);

    // Couleur du texte noire
    $textColor = imagecolorallocate($image, 50, 50, 50);

    // Ajouter le texte (initiales) au centre
    $fontSize = 5; // Taille de la police
    $x = ($width - imagefontwidth($fontSize) * strlen($initials)) / 2;
    $y = ($height - imagefontheight($fontSize)) / 2;
    imagestring($image, $fontSize, $x, $y, $initials, $textColor);

    // Sauvegarder l'image
    imagepng($image, $destination);

    // Libérer la mémoire
    imagedestroy($image);
}

// Supprimer un auteur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    if ($auteurModel->delete($id)) {
        header("Location: auteurs.php?success=Auteur supprimé avec succès");
        exit;
    } else {
        header("Location: auteurs.php?error=Erreur lors de la suppression de l'auteur");
        exit;
    }
}

// Modifier un auteur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom']; // Récupérer le prénom
    $biographie = $_POST['biographie'];

    // Vérifier si une nouvelle photo est uploadée
    $photo = $auteurModel->getById($id)['photo']; // Conserver l'ancienne photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../public/assets/img/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photo = '/public/assets/img/' . basename($_FILES['photo']['name']);
        }
    }

    // Mettre à jour les informations de l'auteur
    if ($auteurModel->update($id, $nom, $prenom, $biographie, $photo)) {
        header("Location: auteurs.php?success=Auteur modifié avec succès");
        exit;
    } else {
        header("Location: auteurs.php?error=Erreur lors de la modification de l'auteur");
        exit;
    }
}

// Ajouter un auteur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nom = $_POST['nom'];
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : ''; // Assurez-vous que le prénom est récupéré
    $biographie = $_POST['biographie'];

    // Gestion de la photo
    $photo = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../public/assets/img/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photo = '/public/assets/img/' . basename($_FILES['photo']['name']);
        } else {
            $error = "Erreur lors du téléchargement de l'image.";
            header("Location: auteurs.php?error=" . urlencode($error));
            exit;
        }
    } else {
        // Générer une image avec les initiales si aucune photo n'est téléchargée
        $uploadDir = '../public/assets/img/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = strtolower($nom[0] . $prenom[0]) . '_default.png'; // Exemple : "jd_default.png"
        $destination = $uploadDir . $fileName;
        generateInitialImage($nom, $prenom, $destination);
        $photo = '/public/assets/img/' . $fileName;
    }

    // Ajouter l'auteur à la base de données
    if ($auteurModel->create($nom, $prenom, $biographie, $photo)) {
        header("Location: auteurs.php?success=Auteur ajouté avec succès");
    } else {
        header("Location: auteurs.php?error=Erreur lors de l'ajout de l'auteur");
    }
    exit;
}

// Récupérer tous les auteurs
$auteurs = $auteurModel->getAll();
?>
