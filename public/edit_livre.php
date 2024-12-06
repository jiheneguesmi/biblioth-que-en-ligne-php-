<?php
require_once '../src/controllers/livresController.php';
require_once '../templates/header.php';


if (!isset($_GET['id'])) {
    header("Location: livres.php?error=Aucun livre sélectionné");
    exit;
}

$id = $_GET['id'];
$livre = $livreModel->getById($id);

if (!$livre) {
    header("Location: livres.php?error=Livre introuvable");
    exit;
}

$auteurs = $auteurModel->getAll();
?>

<div class="container">
    <h1 class="page-title">Modifier le Livre</h1>

    <form method="POST" action="livres.php" class="form-container">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= $livre['id'] ?>">

        <label for="titre">Titre du livre</label>
        <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required class="input-field">

        <label for="genre">Genre du livre</label>
        <input type="text" name="genre" id="genre" value="<?= htmlspecialchars($livre['genre']) ?>" required class="input-field">

        <label for="auteur_id">Choisir un auteur</label>
        <select name="auteur_id" id="auteur_id" class="input-field">
            <option value="" disabled>Choisir un auteur</option>
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= $auteur['id'] ?>" <?= $auteur['id'] == $livre['auteur_id'] ? 'selected' : '' ?>><?= htmlspecialchars($auteur['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="disponibilite">Disponibilité</label>
        <select name="disponibilite" id="disponibilite" class="input-field">
            <option value="1" <?= $livre['disponibilite'] == 1 ? 'selected' : '' ?>>Disponible</option>
            <option value="0" <?= $livre['disponibilite'] == 0 ? 'selected' : '' ?>>Emprunté</option>
        </select>

        <button type="submit" class="btn btn-submit">Enregistrer les modifications</button>
    </form>
</div>
