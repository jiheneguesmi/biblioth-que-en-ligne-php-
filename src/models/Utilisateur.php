<?php
class Utilisateur {
    private $conn;
    private $table = "utilisateurs";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un utilisateur
    public function create($nom, $email, $mot_de_passe, $role) {
        $query = "INSERT INTO " . $this->table . " (nom, email, mot_de_passe, role) 
                  VALUES (:nom, :email, :mot_de_passe, :role)";
        
        $stmt = $this->conn->prepare($query);
    
        // Hasher le mot de passe avant de le stocker
        $hashedPassword = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    
        // Lier les paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $hashedPassword); // Utilisation de la variable
        $stmt->bindParam(':role', $role);
    
        // Exécuter la requête
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    // Obtenir tous les utilisateurs
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modifier un utilisateur
    public function update($id, $nom, $email, $role, $mot_de_passe = null) {
        // Si un mot de passe est fourni, on le met à jour
        if ($mot_de_passe) {
            $hashedPassword = password_hash($mot_de_passe, PASSWORD_BCRYPT);
            $query = "UPDATE " . $this->table . " 
                      SET nom = :nom, email = :email, role = :role, mot_de_passe = :mot_de_passe 
                      WHERE id = :id";
        } else {
            // Si aucun mot de passe n'est fourni, on ne le met pas à jour
            $query = "UPDATE " . $this->table . " 
                      SET nom = :nom, email = :email, role = :role 
                      WHERE id = :id";
        }
    
        $stmt = $this->conn->prepare($query);
    
        // Lier les paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
    
        // Lier le mot de passe si fourni
        if ($mot_de_passe) {
            $stmt->bindParam(':mot_de_passe', $hashedPassword);
        }
    
        // Exécuter la requête
        return $stmt->execute();
    }

    

    // Supprimer un utilisateur
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Vérifier si un utilisateur existe par email
    public function checkIfExists($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
 
     // Récupérer un utilisateur par son email (ou autre colonne si nécessaire)
public function getByUsername($username) {
    $query = "SELECT * FROM utilisateurs WHERE email = :email"; // Ici 'email' est utilisé comme username
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $username);  // Binding avec le paramètre 'username' qui est en réalité un email
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

      
}
?>
