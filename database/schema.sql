CREATE DATABASE IF NOT EXISTS gestion_commerciale;
USE gestion_commerciale;

CREATE TABLE IF NOT EXISTS Gerant (
    id_gerant INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS Client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    adresse VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Produit (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom_produit VARCHAR(150) NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Livreur (
    id_livreur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    matricule_moto VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Commande (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    date_commande DATE NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    statut VARCHAR(50) NOT NULL,
    id_client INT NOT NULL,
    id_livreur INT NULL,
    CONSTRAINT fk_commande_client FOREIGN KEY (id_client) REFERENCES Client(id_client) ON DELETE CASCADE,
    CONSTRAINT fk_commande_livreur FOREIGN KEY (id_livreur) REFERENCES Livreur(id_livreur) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS DetailsCommande (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_commande INT NOT NULL,
    quantite INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_detail_produit FOREIGN KEY (id_produit) REFERENCES Produit(id_produit) ON DELETE CASCADE,
    CONSTRAINT fk_detail_commande FOREIGN KEY (id_commande) REFERENCES Commande(id_commande) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Facture (
    id_facture INT AUTO_INCREMENT PRIMARY KEY,
    date_facture DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    id_commande INT NOT NULL,
    CONSTRAINT fk_facture_commande FOREIGN KEY (id_commande) REFERENCES Commande(id_commande) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Paiement (
    id_paiement INT AUTO_INCREMENT PRIMARY KEY,
    date_paiement DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    type_paiement VARCHAR(50) NOT NULL,
    id_facture INT NOT NULL,
    CONSTRAINT fk_paiement_facture FOREIGN KEY (id_facture) REFERENCES Facture(id_facture) ON DELETE CASCADE
);

INSERT INTO Gerant (nom, prenom, telephone) VALUES ('Admin', 'System', '777777777');
