<?php
require_once '../src/controllers/utilisateursController.php';
require_once '../templates/header.php';
?>

<div class="container">
    <h1 class="page-title">Gestion des Utilisateurs</h1>

    <!-- Affichage des utilisateurs -->
    <div class="list-container">
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <div class="list-item">
                <h2><?= htmlspecialchars($utilisateur['nom']) ?></h2>
                <p>Email: <?= htmlspecialchars($utilisateur['email']) ?></p>
                <p>Rôle: <?= htmlspecialchars($utilisateur['role']) ?></p>

                <!-- Formulaire pour modifier un utilisateur -->
                <form method="GET" action="edit_utilisateur.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                    <button type="submit" class="btn edit">Modifier</button>
                </form>

                <!-- Formulaire pour supprimer un utilisateur -->
                <form method="POST" action="utilisateurs.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">
                    <button type="submit" class="btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Formulaire d'ajout d'utilisateur -->
    <h2>Ajouter un Utilisateur</h2>
    <form method="POST" action="utilisateurs.php">
        <input type="hidden" name="action" value="create">

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" required>

        <label for="role">Rôle</label>
        <select name="role" id="role" required>
            <option value="emprunteur">Emprunteur</option>
            <option value="administrateur">Administrateur</option>
        </select>

        <button type="submit" class="btn submit">Ajouter</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
