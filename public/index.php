<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Accueil</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Style général pour les boutons */
        .btn {
            display: inline-block;
            padding: 15px 30px;
            font-size: 16px;
            color: #fff; /* Texte blanc */
            background-color: #1d1d1d; /* Fond sombre */
            text-decoration: none;
            border-radius: 8px; /* Coins arrondis */
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Légère ombre */
        }

        /* Effet au survol */
        .btn:hover {
            transform: translateY(-3px); /* Soulèvement visuel */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5); /* Augmentation de l'ombre */
        }

        /* Centrer les boutons dans la liste */
        .list-item {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f2f2f2; /* Fond clair */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Ombre des blocs */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .list-item:hover {
            transform: translateY(-5px); /* Soulèvement du bloc au survol */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée */
        }

        .list-item h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .list-item p {
            margin-bottom: 20px;
            color: #555;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<?php
require_once '../templates/header.php'; // Inclure l'en-tête avec la navbar
?>

<div class="container">
    <h1 class="page-title">Bienvenue à la Bibliothèque</h1>
    <p>Gérez vos livres, auteurs, emprunts et utilisateurs en quelques clics.</p>

    <div class="list-container">
        <div class="list-item">
            <h2>Auteurs</h2>
            <p>Gérez la liste des auteurs et les informations associées.</p>
            <a href="auteurs.php" class="btn">Gérer les auteurs</a>
        </div>
        <div class="list-item">
            <h2>Livres</h2>
            <p>Ajoutez, modifiez et consultez les livres disponibles dans la bibliothèque.</p>
            <a href="livres.php" class="btn">Gérer les livres</a>
        </div>
        <div class="list-item">
            <h2>Emprunts</h2>
            <p>Suivez les emprunts et gérez la disponibilité des livres.</p>
            <a href="emprunts.php" class="btn">Gérer les emprunts</a>
        </div>
        <div class="list-item">
            <h2>Utilisateurs</h2>
            <p>Ajoutez et modifiez les utilisateurs de la bibliothèque.</p>
            <a href="utilisateurs.php" class="btn">Gérer les utilisateurs</a>
        </div>
    </div>
</div>

<?php
require_once '../templates/footer.php'; // Inclure le pied de page
?>

</body>
</html>
