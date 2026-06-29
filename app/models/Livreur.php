<?php
class Livreur
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(string $search = ''): array
    {
        if ($search !== '') {
            $stmt = $this->db->prepare('SELECT * FROM Livreur WHERE nom LIKE :search OR prenom LIKE :search OR telephone LIKE :search OR matricule_moto LIKE :search ORDER BY id_livreur DESC');
            $stmt->execute(['search' => '%' . $search . '%']);
            return $stmt->fetchAll();
        }

        $stmt = $this->db->query('SELECT * FROM Livreur ORDER BY id_livreur DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Livreur WHERE id_livreur = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO Livreur (nom, prenom, telephone, matricule_moto) VALUES (:nom, :prenom, :telephone, :matricule_moto)');
        return $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'matricule_moto' => $data['matricule_moto'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE Livreur SET nom = :nom, prenom = :prenom, telephone = :telephone, matricule_moto = :matricule_moto WHERE id_livreur = :id');
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'matricule_moto' => $data['matricule_moto'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Livreur WHERE id_livreur = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM Livreur');
        return (int) $stmt->fetch()['total'];
    }
}
