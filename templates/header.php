<?php
// Vérifier si la session est déjà active avant de la démarrer
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <!-- Lien vers le CSS -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <!-- Font moderne -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Lien vers le CDN Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ajouter dans le <head> de votre page HTML -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>
<!-- Ajouter juste avant votre balise <body> -->
<div id="particles-js"></div>

<body>

<!-- Navbar - Header -->
<header>
<nav>
<a href="index.php" class="navbar-title"><h1>Bibliothèque</h1></a>
<ul>
        <li><a href="index.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">Accueil</a></li>
        <li><a href="auteurs.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'auteurs.php') ? 'active' : '' ?>">Auteurs</a></li>
        <li><a href="livres.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'livres.php') ? 'active' : '' ?>">Livres</a></li>
        <li><a href="emprunts.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'emprunts.php') ? 'active' : '' ?>">Emprunts</a></li>
        <li><a href="utilisateurs.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'utilisateurs.php') ? 'active' : '' ?>">Utilisateurs</a></li>
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<li><a href="logout.php">Se déconnecter</a></li>'; // Afficher le bouton de déconnexion si l'utilisateur est connecté
        } else {
            echo '<li><a href="login.php">Se connecter</a></li>';
        }
        ?>
    </ul>
</nav>

</header>
