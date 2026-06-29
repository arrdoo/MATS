<?php
class Facture
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll('SELECT f.*, c.date_commande, c.montant_total FROM facture f JOIN commande c ON f.id_commande = c.id_commande ORDER BY f.id_facture DESC');
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM facture WHERE id_facture = :id', [':id' => $id]);
    }

    public function create(int $orderId, float $amount): string
    {
        return $this->db->insert(
            'INSERT INTO facture (date_facture, montant, id_commande) VALUES (:date_f, :montant, :commande)',
            [
                ':date_f' => date('Y-m-d'),
                ':montant' => $amount,
                ':commande' => $orderId,
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM facture WHERE id_facture = :id', [':id' => $id]);
    }
}
?>
