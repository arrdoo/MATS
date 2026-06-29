<?php
class Commande
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(string $search = ''): array
    {
        $sql = 'SELECT c.*, cl.nom AS client_nom, cl.prenom AS client_prenom, l.nom AS livreur_nom FROM Commande c LEFT JOIN Client cl ON c.id_client = cl.id_client LEFT JOIN Livreur l ON c.id_livreur = l.id_livreur';
        if ($search !== '') {
            $sql .= ' WHERE c.id_commande LIKE :search OR cl.nom LIKE :search OR cl.prenom LIKE :search OR c.statut LIKE :search';
            $stmt = $this->db->prepare($sql . ' ORDER BY c.id_commande DESC');
            $stmt->execute(['search' => '%' . $search . '%']);
            return $stmt->fetchAll();
        }

        $stmt = $this->db->query($sql . ' ORDER BY c.id_commande DESC');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO Commande (date_commande, montant_total, statut, id_client, id_livreur) VALUES (:date_commande, :montant_total, :statut, :id_client, :id_livreur)');
        $stmt->execute([
            'date_commande' => $data['date_commande'],
            'montant_total' => $data['montant_total'],
            'statut' => $data['statut'],
            'id_client' => $data['id_client'],
            'id_livreur' => $data['id_livreur'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Commande WHERE id_commande = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE Commande SET montant_total = :montant_total, statut = :statut, id_client = :id_client, id_livreur = :id_livreur WHERE id_commande = :id');
        return $stmt->execute([
            'id' => $id,
            'montant_total' => $data['montant_total'],
            'statut' => $data['statut'],
            'id_client' => $data['id_client'],
            'id_livreur' => $data['id_livreur'],
        ]);
    }

    public function delete(int $id): bool
    {
        $this->db->beginTransaction();
        try {
            $this->db->prepare('DELETE FROM DetailsCommande WHERE id_commande = :id')->execute(['id' => $id]);
            $this->db->prepare('DELETE FROM Paiement WHERE id_facture IN (SELECT id_facture FROM Facture WHERE id_commande = :id)')->execute(['id' => $id]);
            $this->db->prepare('DELETE FROM Facture WHERE id_commande = :id')->execute(['id' => $id]);
            $stmt = $this->db->prepare('DELETE FROM Commande WHERE id_commande = :id');
            $success = $stmt->execute(['id' => $id]);
            if ($success) {
                $this->db->commit();
                return true;
            }
            $this->db->rollBack();
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function count(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) as total FROM Commande');
        return (int) $stmt->fetch()['total'];
    }

    public function revenue(): float
    {
        $stmt = $this->db->query('SELECT COALESCE(SUM(montant_total), 0) as total FROM Commande');
        return (float) $stmt->fetch()['total'];
    }

    public function addDetails(int $commandeId, int $produitId, int $quantite, float $montant): bool
    {
        $stmt = $this->db->prepare('INSERT INTO DetailsCommande (id_produit, id_commande, quantite, montant) VALUES (:id_produit, :id_commande, :quantite, :montant)');
        return $stmt->execute([
            'id_produit' => $produitId,
            'id_commande' => $commandeId,
            'quantite' => $quantite,
            'montant' => $montant,
        ]);
    }

    public function getDetails(int $commandeId): array
    {
        $stmt = $this->db->prepare('SELECT d.*, p.nom_produit FROM DetailsCommande d JOIN Produit p ON d.id_produit = p.id_produit WHERE d.id_commande = :id');
        $stmt->execute(['id' => $commandeId]);
        return $stmt->fetchAll();
    }
}
