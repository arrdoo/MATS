<?php
class Gerant
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = ''): array
    {
        if ($search !== '') {
            $sql = 'SELECT * FROM gerant WHERE nom LIKE :search OR prenom LIKE :search OR telephone LIKE :search ORDER BY id_gerant DESC';
            return $this->db->fetchAll($sql, [':search' => '%' . $search . '%']);
        }

        return $this->db->fetchAll('SELECT * FROM gerant ORDER BY id_gerant DESC');
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne('SELECT * FROM gerant WHERE id_gerant = :id', [':id' => $id]);
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO gerant (nom, prenom, telephone) VALUES (:nom, :prenom, :telephone)',
            [
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
            ]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->execute(
            'UPDATE gerant SET nom = :nom, prenom = :prenom, telephone = :telephone WHERE id_gerant = :id',
            [
                ':id' => $id,
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':telephone' => $data['telephone'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM gerant WHERE id_gerant = :id', [':id' => $id]);
    }
}
?>
