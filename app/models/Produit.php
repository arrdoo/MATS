<?php
class Produit
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(string $search = ''): array
    {
        if ($search !== '') {
            $stmt = $this->db->prepare('SELECT * FROM Produit WHERE nom_produit LIKE :search ORDER BY id_produit DESC');
            $stmt->execute(['search' => '%' . $search . '%']);
            return $stmt->fetchAll();
        }

        $stmt = $this->db->query('SELECT * FROM Produit ORDER BY id_produit DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Produit WHERE id_produit = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO Produit (nom_produit, prix_unitaire, quantite_stock) VALUES (:nom_produit, :prix_unitaire, :quantite_stock)');
        return $stmt->execute([
            'nom_produit' => $data['nom_produit'],
            'prix_unitaire' => $data['prix_unitaire'],
            'quantite_stock' => $data['quantite_stock'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE Produit SET nom_produit = :nom_produit, prix_unitaire = :prix_unitaire, quantite_stock = :quantite_stock WHERE id_produit = :id');
        return $stmt->execute([
            'id' => $id,
            'nom_produit' => $data['nom_produit'],
            'prix_unitaire' => $data['prix_unitaire'],
            'quantite_stock' => $data['quantite_stock'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Produit WHERE id_produit = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM Produit');
        return (int) $stmt->fetch()['total'];
    }
}
