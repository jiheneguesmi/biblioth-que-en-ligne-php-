<?php
class Livre {
    private $conn;
    private $table = "livres";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les livres
    public function getAll() {
        // Joindre les auteurs pour obtenir leur nom
        $query = "SELECT livres.id, livres.titre, livres.genre, livres.disponibilite, auteurs.nom AS auteur 
                  FROM livres
                  LEFT JOIN auteurs ON livres.auteur_id = auteurs.id";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllAvailable() {
        $query = "SELECT * FROM livres WHERE disponibilite = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //Verfie disponibilité livre
    public function isAvailable($id_livre) {
        $query = "SELECT disponibilite FROM livres WHERE id = :id_livre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->execute();
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $livre['disponibilite'] == 1; // Si le livre est disponible (disponibilite = 1)
    }
    public function updateAvailability($id_livre, $disponibilite) {
        $query = "UPDATE livres SET disponibilite = :disponibilite WHERE id = :id_livre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->bindParam(':disponibilite', $disponibilite);
        $stmt->execute();
    }
    
    // Créer un livre
    public function create($titre, $genre, $auteur_id, $disponibilite) {
        $query = "INSERT INTO " . $this->table . " (titre, genre, auteur_id, disponibilite) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titre, $genre, $auteur_id, $disponibilite]);
    }

    // Mettre à jour un livre
    public function update($id, $titre, $genre, $auteur_id, $disponibilite) {
        $query = "UPDATE " . $this->table . " SET titre = ?, genre = ?, auteur_id = ?, disponibilite = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$titre, $genre, $auteur_id, $disponibilite, $id]);
    }

    // Supprimer un livre
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Récupérer un livre par son ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
