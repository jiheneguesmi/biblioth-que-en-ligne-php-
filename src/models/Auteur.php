<?php
class Auteur {
    private $conn;
    private $table = "auteurs";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les auteurs
    public function getAll() {
        $query = "SELECT id, nom, prenom, biographie, photo FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un auteur par ID
    public function getById($id) {
        $query = "SELECT id, nom, prenom, biographie, photo FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Supprimer un auteur
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Modifier un auteur
    public function update($id, $nom, $prenom, $biographie, $photo) {
        $query = "UPDATE " . $this->table . " SET nom = ?, prenom = ?, biographie = ?, photo = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nom, $prenom, $biographie, $photo, $id]);
    }

    // Ajouter un auteur
    public function create($nom, $prenom, $biographie, $photo) {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, biographie, photo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nom, $prenom, $biographie, $photo]);
    }
}
?>
