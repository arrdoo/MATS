<?php
class Commande
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(string $search = ''): array
    {
        if ($search !== '') {
            return $this->db->fetchAll(
                'SELECT c.*, cl.nom AS client_nom, cl.prenom AS client_prenom, l.nom AS livreur_nom FROM commande c LEFT JOIN client cl ON c.id_client = cl.id_client LEFT JOIN livreur l ON c.id_livreur = l.id_livreur WHERE cl.nom LIKE :search OR cl.prenom LIKE :search OR c.statut LIKE :search ORDER BY c.id_commande DESC',
                [':search' => '%' . $search . '%']
            );
        }

        return $this->db->fetchAll(
            'SELECT c.*, cl.nom AS client_nom, cl.prenom AS client_prenom, l.nom AS livreur_nom FROM commande c LEFT JOIN client cl ON c.id_client = cl.id_client LEFT JOIN livreur l ON c.id_livreur = l.id_livreur ORDER BY c.id_commande DESC'
        );
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne(
            'SELECT c.*, cl.nom AS client_nom, cl.prenom AS client_prenom, l.nom AS livreur_nom FROM commande c LEFT JOIN client cl ON c.id_client = cl.id_client LEFT JOIN livreur l ON c.id_livreur = l.id_livreur WHERE c.id_commande = :id',
            [':id' => $id]
        );
    }

    public function create(array $data): string
    {
        return $this->db->insert(
            'INSERT INTO commande (date_commande, montant_total, statut, id_client, id_livreur) VALUES (:date_c, :montant, :statut, :client, :livreur)',
            [
                ':date_c' => $data['date_commande'],
                ':montant' => $data['montant_total'],
                ':statut' => $data['statut'],
                ':client' => $data['id_client'],
                ':livreur' => $data['id_livreur'],
            ]
        );
    }

    public function addDetails(int $orderId, int $productId, int $quantity, float $amount): bool
    {
        return $this->db->execute(
            'INSERT INTO detailscommande (id_produit, id_commande, quantite, montant) VALUES (:prod, :cmd, :qty, :amount)',
            [':prod' => $productId, ':cmd' => $orderId, ':qty' => $quantity, ':amount' => $amount]
        );
    }

    public function getDetails(int $orderId): array
    {
        return $this->db->fetchAll(
            'SELECT d.*, p.nom_produit FROM detailscommande d JOIN produit p ON d.id_produit = p.id_produit WHERE d.id_commande = :id',
            [':id' => $orderId]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->execute(
            'UPDATE commande SET montant_total = :montant, statut = :statut, id_client = :client, id_livreur = :livreur WHERE id_commande = :id',
            [
                ':id' => $id,
                ':montant' => $data['montant_total'],
                ':statut' => $data['statut'],
                ':client' => $data['id_client'],
                ':livreur' => $data['id_livreur'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        $this->db->execute('DELETE FROM detailscommande WHERE id_commande = :id', [':id' => $id]);
        return $this->db->execute('DELETE FROM commande WHERE id_commande = :id', [':id' => $id]);
    }
}
?>
