<?php
class Facture
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT f.*, c.id_commande FROM Facture f JOIN Commande c ON f.id_commande = c.id_commande ORDER BY f.id_facture DESC');
        return $stmt->fetchAll();
    }

    public function create(int $commandeId, float $montant): int
    {
        $stmt = $this->db->prepare('INSERT INTO Facture (date_facture, montant, id_commande) VALUES (:date_facture, :montant, :id_commande)');
        $stmt->execute([
            'date_facture' => date('Y-m-d'),
            'montant' => $montant,
            'id_commande' => $commandeId,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function findByCommande(int $commandeId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Facture WHERE id_commande = :id');
        $stmt->execute(['id' => $commandeId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
