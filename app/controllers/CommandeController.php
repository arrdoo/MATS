<?php
class CommandeController
{
    private Commande $model;
    private Produit $produitModel;
    private Facture $factureModel;

    public function __construct()
    {
        $this->model = new Commande();
        $this->produitModel = new Produit();
        $this->factureModel = new Facture();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $commandes = $this->model->all($search);
        $clients = (new Client())->all();
        $livreurs = (new Livreur())->all();
        $produits = $this->produitModel->all();
        include __DIR__ . '/../views/commandes.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int) ($_POST['id_client'] ?? 0);
            $livreurId = (int) ($_POST['id_livreur'] ?? 0);
            $statut = trim($_POST['statut'] ?? 'En attente');
            $produits = $_POST['produits'] ?? [];

            if ($clientId <= 0 || empty($produits)) {
                $_SESSION['error'] = 'Sélectionnez un client et au moins un produit.';
                header('Location: /index.php?route=commandes');
                exit;
            }

            $commandeId = $this->model->create([
                'date_commande' => date('Y-m-d'),
                'montant_total' => 0,
                'statut' => $statut,
                'id_client' => $clientId,
                'id_livreur' => $livreurId > 0 ? $livreurId : null,
            ]);

            if ($commandeId > 0) {
                $total = 0;
                foreach ($produits as $item) {
                    $produitId = (int) ($item['id'] ?? 0);
                    $qty = max(1, (int) ($item['quantite'] ?? 1));
                    $produit = $this->produitModel->find($produitId);
                    if ($produit) {
                        $montant = (float) $produit['prix_unitaire'] * $qty;
                        $this->model->addDetails($commandeId, $produitId, $qty, $montant);
                        $total += $montant;
                    }
                }
                $this->model->update($commandeId, [
                    'montant_total' => $total,
                    'statut' => $statut,
                    'id_client' => $clientId,
                    'id_livreur' => $livreurId > 0 ? $livreurId : null,
                ]);
                $this->factureModel->create($commandeId, $total);
                $_SESSION['success'] = 'Commande créée avec succès.';
            } else {
                $_SESSION['error'] = 'Erreur lors de la création de la commande.';
            }
            header('Location: /index.php?route=commandes');
            exit;
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Commande supprimée avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        header('Location: /index.php?route=commandes');
        exit;
    }
}
