<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../src/config/database.php';
    require_once '../src/models/Utilisateur.php';

    $db = new Database();
    $conn = $db->getConnection();
    $utilisateurModel = new Utilisateur($conn);

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // L'utilisateur peut avoir un rôle (par exemple, "utilisateur" ou "admin")

    // Vérifier si l'email est déjà utilisé
    if ($utilisateurModel->checkIfExists($email)) {
        $error = "Cet email est déjà utilisé.";
    } else {
        // Créer l'utilisateur
        if ($utilisateurModel->create($nom, $email, $password, $role)) {
            // Rediriger vers la page de connexion
            header("Location: login.php?success=Inscription réussie. Vous pouvez maintenant vous connecter.");
            exit;
        } else {
            $error = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Bibliothèque</title>
    <link rel="stylesheet" href="assets/css/style1.css">
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1; /* Placer les particules derrière le contenu */
            background: linear-gradient(135deg, #333, #414141e8, #4141419c); /* Gradient doux */
        }

        .register-container {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.9); /* Fond translucide pour le contraste */
            border-radius: 10px;
            padding: 20px 40px;
            width: 300px;
            text-align: center;
            margin: 100px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .register-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .register-container input, .register-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background: #414141e8;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .register-container button:hover {
            background: #333;
        }

        .register-container a {
            text-decoration: none;
            color: #414141e8;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Fond dynamique avec particules -->
<div id="particles-js"></div>

<!-- Conteneur d'inscription -->
<div class="register-container">
    <h2>Inscription à la Bibliothèque</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <select name="role" required>
            <option value="utilisateur">Utilisateur</option>
            <option value="administrateur">Administrateur</option>
        </select>
        <button type="submit" class="btn">S'inscrire</button>
    </form>

    <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
</div>

<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                }
            },
            "opacity": {
                "value": 0.8,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0.3,
                    "sync": false
                }
            },
            "size": {
                "value": 4,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 5,
                    "size_min": 0.2,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 3,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": true,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "repulse": {
                    "distance": 120,
                    "duration": 0.6
                },
                "push": {
                    "particles_nb": 4
                }
            }
        },
        "retina_detect": true
    });
</script>

</body>
</html>
