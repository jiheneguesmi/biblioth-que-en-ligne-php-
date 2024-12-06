<?php
require_once '../src/controllers/utilisateursController.php';
require_once '../templates/header.php';

if (!isset($_GET['id'])) {
    header("Location: utilisateurs.php?error=Aucun utilisateur sélectionné");
    exit;
}

$id = $_GET['id'];
$utilisateur = $utilisateurModel->getById($id);

if (!$utilisateur) {
    header("Location: utilisateurs.php?error=Utilisateur introuvable");
    exit;
}
?>

<div class="container">
    <h1>Modifier l'Utilisateur</h1>
    <form method="POST" action="utilisateurs.php">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?= $utilisateur['id'] ?>">

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($utilisateur['nom']) ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>

        <label for="role">Rôle</label>
        <select name="role" id="role" required>
            <option value="emprunteur" <?= $utilisateur['role'] == 'emprunteur' ? 'selected' : '' ?>>Emprunteur</option>
            <option value="administrateur" <?= $utilisateur['role'] == 'administrateur' ? 'selected' : '' ?>>Administrateur</option>
        </select>

        <label for="mot_de_passe">Mot de passe (laissez vide si inchangé)</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe">

        <button type="submit" class="btn">Enregistrer les modifications</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>
