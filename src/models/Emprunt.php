<?php
class Emprunt {
    private $conn;
    private $table = "emprunts";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ajouter un emprunt
    public function create($id_livre, $id_utilisateur, $date_retour_prevu) {
        $query = "INSERT INTO " . $this->table . " (id_livre, id_utilisateur, date_retour_prevu) 
                  VALUES (:id_livre, :id_utilisateur, :date_retour_prevu)";

        $stmt = $this->conn->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->bindParam(':date_retour_prevu', $date_retour_prevu);

        // Exécuter la requête
        return $stmt->execute();
    }

     // Récupérer l'ID du livre à partir de l'ID de l'emprunt
     public function getBookIdByEmprunt($id_emprunt) {
        $query = "SELECT id_livre FROM " . $this->table . " WHERE id_emprunt = :id_emprunt";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_emprunt', $id_emprunt);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_livre'] : null; // Retourne l'ID du livre ou null si l'emprunt n'est pas trouvé
    }
    
    // Récupérer tous les emprunts actifs (non retournés)
    public function getAllActive() {
        $query = "SELECT emprunts.id_emprunt, livres.titre, utilisateurs.nom AS utilisateur, emprunts.date_emprunt, emprunts.date_retour_prevu
                  FROM " . $this->table . " 
                  JOIN livres ON emprunts.id_livre = livres.id
                  JOIN utilisateurs ON emprunts.id_utilisateur = utilisateurs.id
                  WHERE emprunts.date_retour_reel IS NULL"; // Seulement les emprunts non retournés
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    // Marquer un emprunt comme retourné
    public function returnBook($id_emprunt) {
        $query = "UPDATE " . $this->table . " SET date_retour_reel = CURRENT_DATE WHERE id_emprunt = :id_emprunt";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_emprunt', $id_emprunt);
        return $stmt->execute();
    }

    // Vérifier si un livre est déjà emprunté
    public function checkBookAvailability($id_livre) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id_livre = :id_livre AND date_retour_reel IS NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_livre', $id_livre);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        
        return $result == 0; // Si 0, le livre est disponible
    }
}
?>
