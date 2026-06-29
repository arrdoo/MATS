<?php
class Client
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = ''): array
    {
        if ($search !== '') {
            $sql = 'SELECT * FROM client WHERE nom LIKE :search OR prenom LIKE :search OR telephone LIKE :search ORDER BY id_client DESC';
            return $this->db->fetchAll($sql, [':search' => '%' . $search . '%']);
        }

        return $this->db->fetchAll('SELECT * FROM client ORDER BY id_client DESC');
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM client WHERE id_client = :id', [':id' => $id]);
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO client (nom, prenom, telephone, adresse) VALUES (:nom, :prenom, :telephone, :adresse)',
            [
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
                ':adresse' => $data['adresse'],
            ]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->execute(
            'UPDATE client SET nom = :nom, prenom = :prenom, telephone = :telephone, adresse = :adresse WHERE id_client = :id',
            [
                ':id' => $id,
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
                ':adresse' => $data['adresse'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM client WHERE id_client = :id', [':id' => $id]);
    }
}
?>
