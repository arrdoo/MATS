<?php
class Produit
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = ''): array
    {
        if ($search !== '') {
            $sql = 'SELECT * FROM produit WHERE nom_produit LIKE :search OR prix_unitaire LIKE :search ORDER BY id_produit DESC';
            return $this->db->fetchAll($sql, [':search' => '%' . $search . '%']);
        }

        return $this->db->fetchAll('SELECT * FROM produit ORDER BY id_produit DESC');
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM produit WHERE id_produit = :id', [':id' => $id]);
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO produit (nom_produit, prix_unitaire, quantite_stock) VALUES (:nom, :prix, :stock)',
            [
                ':nom' => $data['nom_produit'],
                ':prix' => $data['prix_unitaire'],
                ':stock' => $data['quantite_stock'],
            ]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->execute(
            'UPDATE produit SET nom_produit = :nom, prix_unitaire = :prix, quantite_stock = :stock WHERE id_produit = :id',
            [
                ':id' => $id,
                ':nom' => $data['nom_produit'],
                ':prix' => $data['prix_unitaire'],
                ':stock' => $data['quantite_stock'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM produit WHERE id_produit = :id', [':id' => $id]);
    }

    public function decreaseStock(int $id, int $quantity): bool
    {
        $product = $this->getById($id);
        if (!$product || (int)$product['quantite_stock'] < $quantity) {
            return false;
        }

        return $this->db->execute(
            'UPDATE produit SET quantite_stock = quantite_stock - :qte WHERE id_produit = :id',
            [':qte' => $quantity, ':id' => $id]
        );
    }
}
?>
