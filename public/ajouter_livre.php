<?php
require_once '../src/controllers/livresController.php';
require_once '../templates/header.php';
?>

<div class="container">
    <h1 class="page-title">Ajouter un Livre</h1>

    <form method="POST" action="ajouter_livre.php" class="form-container">
        <input type="hidden" name="action" value="create">

        <label for="titre">Titre du livre</label>
        <input type="text" name="titre" id="titre" required class="input-field">

        <label for="genre">Genre du livre</label>
        <input type="text" name="genre" id="genre" required class="input-field">

        <label for="auteur_id">Choisir un auteur</label>
        <select name="auteur_id" id="auteur_id" class="input-field">
            <option value="" disabled selected>Choisir un auteur</option>
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= $auteur['id'] ?>"><?= htmlspecialchars($auteur['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="disponibilite">Disponibilité</label>
        <select name="disponibilite" id="disponibilite" class="input-field">
            <option value="1">Disponible</option>
            <option value="0">Emprunté</option>
        </select>

        <button type="submit" class="btn btn-submit">Ajouter le Livre</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
