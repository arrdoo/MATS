<?php
class FactureController
{
    private Facture $model;

    public function index(): void
    {
        $factures = (new Facture())->all();
        include __DIR__ . '/../views/factures.php';
    }
}
