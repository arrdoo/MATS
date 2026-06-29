<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Commande.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Produit.php';
require_once __DIR__ . '/../models/Livreur.php';

class CommandeController
{
    private Commande $model;
    private Client $clientModel;
    private Produit $produitModel;
    private Livreur $livreurModel;

    public function __construct()
    {
        $this->model = new Commande();
        $this->clientModel = new Client();
        $this->produitModel = new Produit();
        $this->livreurModel = new Livreur();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $commandes = $this->model->getAll($search);
        $clients = $this->clientModel->getAll();
        $livreurs = $this->livreurModel->getAll();
        $produits = $this->produitModel->getAll();
        require __DIR__ . '/../views/commandes.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)($_POST['id_client'] ?? 0);
            $livreurId = (int)($_POST['id_livreur'] ?? 0);
            $products = json_decode($_POST['products'] ?? '[]', true) ?: [];
            $totals = (float)($_POST['montant_total'] ?? 0);

            $orderId = $this->model->create([
                'date_commande' => date('Y-m-d'),
                'montant_total' => $totals,
                'statut' => $_POST['statut'],
                'id_client' => $clientId,
                'id_livreur' => $livreurId,
            ]);

            require_once __DIR__ . '/../models/Facture.php';
            $factureModel = new Facture();
            $factureModel->create($orderId, $totals);

            foreach ($products as $productData) {
                $productId = (int)$productData['id'];
                $quantity = (int)$productData['quantity'];
                $amount = (float)$productData['amount'];
                $this->produitModel->decreaseStock($productId, $quantity);
                $this->model->addDetails($orderId, $productId, $quantity, $amount);
            }

            header('Location: /index.php?action=commandes');
            exit;
        }
    }
}
