<?php
require_once '../src/controllers/empruntsController.php';
require_once '../templates/header.php';
?>

<div class="container">
    <h1 class="page-title">Gestion des Emprunts</h1>

    <!-- Affichage des emprunts actifs -->
    <div class="list-container">
        <?php foreach ($emprunts as $emprunt): ?>
            <div class="list-item">
                <h2><?= htmlspecialchars($emprunt['titre']) ?></h2>
                <p>Emprunté par: <?= htmlspecialchars($emprunt['utilisateur']) ?></p>
                <p>Date d'emprunt: <?= htmlspecialchars($emprunt['date_emprunt']) ?></p>
                <p>Date de retour prévue: <?= htmlspecialchars(string: $emprunt['date_retour_prevu']) ?></p>

                <!-- Formulaire pour retourner un livre -->
                <form method="POST" action="emprunts.php" style="display:inline;">
                    <input type="hidden" name="action" value="return">
                    <input type="hidden" name="id_emprunt" value="<?= $emprunt['id_emprunt'] ?>">
                    <button type="submit" class="btn return">Retourner le livre</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulaire pour emprunter un livre -->
    <h2>Emprunter un Livre</h2>
    <form method="POST" action="emprunts.php">
    <input type="hidden" name="action" value="create">

    <label for="id_livre">Choisir un livre</label>
    <select name="id_livre" id="id_livre" required>
        <?php foreach ($livres as $livre): ?>
            <option value="<?= $livre['id'] ?>"><?= $livre['titre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="id_utilisateur">Choisir un utilisateur</label>
    <select name="id_utilisateur" id="id_utilisateur" required>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= $utilisateur['id'] ?>"><?= $utilisateur['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <label for="date_retour_prevu">Date de retour prévue</label>
    <input type="date" name="date_retour_prevu" id="date_retour_prevu" required>

    <button type="submit" class="btn submit">Emprunter</button>
</form>

</div>

<?php require_once '../templates/footer.php'; ?>
