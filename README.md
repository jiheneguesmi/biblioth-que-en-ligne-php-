# Gestion d'une bibliothèque en ligne

Ce projet consiste à développer une application permettant de gérer une bibliothèque en ligne, avec des fonctionnalités CRUD pour les livres, les auteurs, et les utilisateurs inscrits pour emprunter les livres. L'application suit également les emprunts et gère la disponibilité des livres.

## Fonctionnalités principales

### 1. Gestion des auteurs
- CRUD pour la gestion des auteurs.
- Chaque auteur a les attributs suivants :
  - `id` (unique)
  - `nom`
  - `biographie` (facultatif)
  - `photo`
- Chaque auteur peut être associé à une liste de livres.

### 2. Gestion des livres
- CRUD pour la gestion des livres.
- Un livre possède les attributs suivants :
  - `id` (unique)
  - `titre`
  - `genre`
  - `auteur_id` (clé étrangère vers la table des auteurs)
  - `disponibilité` (boolean) — indique si le livre est disponible ou emprunté.
  - Si le livre n'est pas disponible, la date de retour prévue sera affichée.
- Lorsqu'un utilisateur clique sur un livre, il est redirigé vers une page détaillant plus d'informations sur le livre, y compris sa disponibilité et son auteur.

### 3. Gestion des emprunts
- Un utilisateur inscrit peut emprunter un livre.
- Le système permet de suivre les emprunts avec les attributs suivants :
  - `id_emprunt`
  - `id_livre`
  - `nom_utilisateur`
  - `date_emprunt`
  - `date_retour` (prévue ou réelle)
- La date de retour estimée est affichée lorsque le livre est emprunté.
- Le système vérifie la disponibilité des livres et empêche l'emprunt d'un livre déjà pris.

### 4. Gestion des utilisateurs
- CRUD pour la gestion des utilisateurs inscrits à la bibliothèque.
- Chaque utilisateur peut être soit un emprunteur, soit un administrateur (pour la gestion des livres et des emprunts).
- Un utilisateur possède un historique des livres empruntés.

## Détails techniques

### Base de données
#### Tables :
- **Auteurs** : `id`, `nom`, `biographie`, `photo`
- **Livres** : `id`, `titre`, `genre`, `auteur_id`, `disponibilité`, `date_retour`
- **Emprunts** : `id_emprunt`, `id_livre`, `nom_utilisateur`, `date_emprunt`, `date_retour`
- **Utilisateurs** : `id`, `nom`, `email`, `role` (emprunteur/admin)

### Frontend (HTML/CSS)
- Interface permettant de visualiser et gérer les livres, les auteurs, et les utilisateurs.
- Pages de détail pour chaque livre et auteur.
- Tableau des livres empruntés avec la date de retour estimée.

### Backend (PHP/MySQL)
- Utilisation de PHP pour gérer les opérations CRUD et les relations entre les livres et les auteurs.
- Fonction de vérification de la disponibilité des livres et des emprunts en cours.

### Améliorations supplémentaires (optionnelles)
#### Recherche autocomplete pour les livres
- Implémentation d'un champ de recherche pour les titres de livres.
  - La chaîne de recherche est récupérée via `$_GET['query']`.
  - Requête SQL pour rechercher les livres correspondants.
  - Récupération des résultats avec : `$results = $stmt->fetchAll(PDO::FETCH_ASSOC);`.
  - Les résultats sont envoyés en JSON avec : `echo json_encode(array_column($results, 'nom'));`.
- Lorsqu'un utilisateur tape les premières lettres du titre d'un livre, une liste déroulante apparaît avec des suggestions de livres correspondants, facilitant la recherche.

## Prérequis

- Serveur PHP et MySQL.
- Navigateur web pour l'interface frontend (HTML/CSS).

## Installation

1. Clonez ce repository sur votre machine locale.
2. Configurez la base de données MySQL avec les tables mentionnées ci-dessus.
3. Mettez à jour les informations de connexion à la base de données dans le fichier de configuration PHP.
4. Accédez à l'application via un serveur local pour commencer à gérer la bibliothèque.

