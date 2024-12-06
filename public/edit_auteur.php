<?php
require_once '../src/controllers/auteursController.php';
require_once '../templates/header.php';

if (!isset($_GET['id'])) {
    header("Location: auteurs.php?error=Aucun auteur sélectionné");
    exit;
}

$id = $_GET['id'];
$auteur = $auteurModel->getById($id);

if (!$auteur) {
    header("Location: auteurs.php?error=Auteur introuvable");
    exit;
}
?>

<div class="container">
    <h1 class="page-title">Modifier l'Auteur</h1>

    <div class="form-container">
        <form method="POST" action="auteurs.php" enctype="multipart/form-data" class="edit-form">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $auteur['id'] ?>">

            <label for="nom">Nom de l'auteur</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($auteur['nom']) ?>" required class="input-field">

            
            <label for="prenom">prenom de l'auteur</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($auteur['prenom']) ?>" required class="input-field">


            <label for="biographie">Biographie</label>
            <textarea name="biographie" id="biographie" class="input-field"><?= htmlspecialchars($auteur['biographie']) ?></textarea>

            <label>Photo actuelle</label><br>
            <img src="http://localhost/projetbib<?= htmlspecialchars($auteur['photo']) ?>" 
                 alt="Photo actuelle" 
                 style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;"><br>

            <label for="photo">Nouvelle photo (optionnel)</label>
            <input type="file" name="photo" id="photo" accept="image/*" class="input-field">

            <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
        </form>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>
