<?php
require_once '../src/controllers/livresController.php';
require_once '../templates/header.php';
?>

<!-- Script pour basculer l'affichage du formulaire -->
<script>
    function toggleForm() {
        var form = document.getElementById("addLivreForm");
        var button = document.getElementById("addLivreBtn");

        // Basculer la visibilité du formulaire
        if (form.classList.contains("hidden")) {
            form.classList.remove("hidden");
            button.innerText = "Annuler l'ajout"; // Changer le texte du bouton
        } else {
            form.classList.add("hidden");
            button.innerText = "Ajouter un livre"; // Revenir à l'initial
        }
    }
</script>

<!-- Ajouter un livre -->
<button id="addLivreBtn" class="btn add-author-btn" onclick="toggleForm()">Ajouter un livre</button>

<!-- Formulaire caché pour ajouter un livre -->
<div id="addLivreForm" class="form-container hidden">
    <h2>Ajouter un livre</h2>
    <form action="livres.php" method="POST">
        <input type="hidden" name="action" value="create">

        <!-- Titre du livre -->
        <div class="form-group">
            <label for="titre">Titre du livre</label>
            <input type="text" name="titre" id="titre" required>
        </div>

        <!-- Genre -->
        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" required>
        </div>

        <!-- Sélectionner un auteur -->
        <div class="form-group">
            <label for="auteur_id">Choisir un auteur</label>
            <select name="auteur_id" id="auteur_id" required>
                <option value="">Sélectionner un auteur</option>
                <?php foreach ($auteurs as $auteur): ?>
                    <option value="<?= $auteur['id'] ?>"><?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Disponibilité -->
        <div class="form-group">
            <label for="disponibilite">Disponible</label>
            <input type="checkbox" name="disponibilite" id="disponibilite" value="1" checked>
        </div>

        <button type="submit">Ajouter</button>
    </form>
</div>

<div class="container">
    <h1 class="page-title">Gestion des Livres</h1>

    <!-- Affichage des messages de succès ou d'erreur -->
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php elseif (isset($_GET['success'])): ?>
        <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>

    <!-- Liste des livres -->  
    <div class="list-container">
        <?php if (!empty($livres)): ?>
            <?php foreach ($livres as $livre): ?>
                <div class="list-item">
                    <div>
                        <h2><?= htmlspecialchars($livre['titre']) ?></h2>
                        <p>Genre: <?= htmlspecialchars($livre['genre']) ?></p>
                        <p>Auteur: <?= htmlspecialchars($livre['auteur']) ?></p> <!-- Affichage du nom de l'auteur -->
                        <p>Disponibilité: <?= $livre['disponibilite'] ? 'Disponible' : 'Emprunté' ?></p>
                    </div>
                    <div class="actions">
                        <!-- Formulaire pour modifier un livre -->
                        <form method="GET" action="edit_livre.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $livre['id'] ?>">
                            <button type="submit" class="btn edit">Modifier</button>
                        </form>

                        <!-- Formulaire pour supprimer un livre -->
                        <form method="POST" action="livres.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $livre['id'] ?>">
                            <button type="submit" class="btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun livre trouvé dans la base de données.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>
