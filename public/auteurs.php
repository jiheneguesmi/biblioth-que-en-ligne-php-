<?php
require_once '../src/controllers/auteursController.php';
require_once '../templates/header.php';
?>

<!-- Affichage des messages de succès ou d'erreur -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<!-- Script pour basculer l'affichage du formulaire -->
<script>
    function toggleForm() {
        var form = document.getElementById("addAuthorForm");
        var button = document.getElementById("addAuthorBtn");

        // Basculer la visibilité du formulaire
        if (form.classList.contains("hidden")) {
            form.classList.remove("hidden");
            button.innerText = "Annuler l'ajout"; // Changer le texte du bouton
        } else {
            form.classList.add("hidden");
            button.innerText = "Ajouter un auteur"; // Revenir à l'initial
        }
    }
</script>

<!-- Ajouter un auteur -->
<button id="addAuthorBtn" class="btn add-author-btn" onclick="toggleForm()">Ajouter un auteur</button>

<!-- Formulaire caché pour ajouter un auteur -->
<div id="addAuthorForm" class="form-container hidden">
    <h2>Ajouter un auteur</h2>
    <form method="POST" action="auteurs.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <input type="text" name="nom" placeholder="Nom de l'auteur" required>
        <input type="text" name="prenom" placeholder="Prénom de l'auteur">
        <textarea name="biographie" placeholder="Biographie"></textarea>
        <input type="file" name="photo" accept="image/*">
        <button type="submit" >Ajouter</button>
    </form>
</div>

<!-- Liste des auteurs -->
<div class="list-container">
    <?php foreach ($auteurs as $auteur): ?>
        <div class="list-item">
            <div class="author-card">
                <div class="author-photo">
                    <img src="http://localhost/projetbib<?= htmlspecialchars($auteur['photo']) ?>" 
                         alt="Photo de <?= htmlspecialchars($auteur['nom']) ?>" 
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                </div>
                <div class="author-info">
                    <h3 class="author-name"><?= htmlspecialchars($auteur['nom']) ?> 
                    <?php 
        // Vérification si le prénom existe et s'il est non vide
        $prenom = trim($auteur['prenom']); // Supprimer les espaces avant et après
        echo !empty($prenom) ? htmlspecialchars($prenom) : 'Non renseigné'; 
    ?>
                    </h3>
                    <p class="author-biography"><?= htmlspecialchars($auteur['biographie']) ?></p>
                </div>
            </div>
            <div class="author-actions">
                <!-- Formulaire pour supprimer l'auteur -->
                <form method="POST" action="auteurs.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $auteur['id'] ?>">
                    <button type="submit" class="btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')">Supprimer</button>
                </form>

                <!-- Formulaire pour modifier l'auteur -->
                <form method="GET" action="edit_auteur.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $auteur['id'] ?>">
                    <button type="submit" class="btn edit">Modifier</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once '../templates/footer.php';
?>
