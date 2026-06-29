<?php
class Paiement
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        return $this->db->fetchAll('SELECT p.*, f.id_facture FROM paiement p JOIN facture f ON p.id_facture = f.id_facture ORDER BY p.id_paiement DESC');
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO paiement (date_paiement, montant, type_paiement, id_facture) VALUES (:date_p, :montant, :type, :facture)',
            [
                ':date_p' => $data['date_paiement'],
                ':montant' => $data['montant'],
                ':type' => $data['type_paiement'],
                ':facture' => $data['id_facture'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM paiement WHERE id_paiement = :id', [':id' => $id]);
    }
}
?>
