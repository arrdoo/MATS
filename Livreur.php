<?php
class Livreur
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = ''): array
    {
        if ($search !== '') {
            $sql = 'SELECT * FROM livreur WHERE nom LIKE :search OR prenom LIKE :search OR telephone LIKE :search OR matricule_moto LIKE :search ORDER BY id_livreur DESC';
            return $this->db->fetchAll($sql, [':search' => '%' . $search . '%']);
        }

        return $this->db->fetchAll('SELECT * FROM livreur ORDER BY id_livreur DESC');
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM livreur WHERE id_livreur = :id', [':id' => $id]);
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO livreur (nom, prenom, telephone, matricule_moto) VALUES (:nom, :prenom, :telephone, :matricule)',
            [
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
                ':matricule' => $data['matricule_moto'],
            ]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->execute(
            'UPDATE livreur SET nom = :nom, prenom = :prenom, telephone = :telephone, matricule_moto = :matricule WHERE id_livreur = :id',
            [
                ':id' => $id,
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
                ':matricule' => $data['matricule_moto'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM livreur WHERE id_livreur = :id', [':id' => $id]);
    }
}
?>
