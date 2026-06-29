<?php
class Client
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(string $search = ''): array
    {
        if ($search !== '') {
            $stmt = $this->db->prepare('SELECT * FROM Client WHERE nom LIKE :search OR prenom LIKE :search OR telephone LIKE :search ORDER BY id_client DESC');
            $stmt->execute(['search' => '%' . $search . '%']);
            return $stmt->fetchAll();
        }

        $stmt = $this->db->query('SELECT * FROM Client ORDER BY id_client DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Client WHERE id_client = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO Client (nom, prenom, telephone, adresse) VALUES (:nom, :prenom, :telephone, :adresse)');
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE Client SET nom = :nom, prenom = :prenom, telephone = :telephone, adresse = :adresse WHERE id_client = :id');
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Client WHERE id_client = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM Client');
        return (int) $stmt->fetch()['total'];
    }
}
