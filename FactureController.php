<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Facture.php';

class FactureController
{
    private Facture $model;

    public function __construct()
    {
        $this->model = new Facture();
    }

    public function index(): void
    {
        $factures = $this->model->getAll();
        require __DIR__ . '/../views/factures.php';
    }

    public function create(): void
    {
        $orderId = (int)($_GET['order_id'] ?? 0);
        $amount = (float)($_GET['amount'] ?? 0);
        $this->model->create($orderId, $amount);
        header('Location: /index.php?action=factures');
        exit;
    }
}
