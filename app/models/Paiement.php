<?php
class Paiement
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT p.*, f.id_facture FROM Paiement p JOIN Facture f ON p.id_facture = f.id_facture ORDER BY p.id_paiement DESC');
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO Paiement (date_paiement, montant, type_paiement, id_facture) VALUES (:date_paiement, :montant, :type_paiement, :id_facture)');
        return $stmt->execute([
            'date_paiement' => $data['date_paiement'],
            'montant' => $data['montant'],
            'type_paiement' => $data['type_paiement'],
            'id_facture' => $data['id_facture'],
        ]);
    }
}
