<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Paiement.php';
require_once __DIR__ . '/../models/Facture.php';

class PaiementController
{
    private Paiement $model;
    private Facture $factureModel;

    public function __construct()
    {
        $this->model = new Paiement();
        $this->factureModel = new Facture();
    }

    public function index(): void
    {
        $factures = $this->factureModel->getAll();
        $paiements = $this->model->getAll();
        require __DIR__ . '/../views/paiements.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: /index.php?action=paiements');
            exit;
        }
    }
}
