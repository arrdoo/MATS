<?php
class PaiementController
{
    private Paiement $model;

    public function index(): void
    {
        $paiements = (new Paiement())->all();
        include __DIR__ . '/../views/paiements.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'date_paiement' => $_POST['date_paiement'] ?? date('Y-m-d'),
                'montant' => (float) ($_POST['montant'] ?? 0),
                'type_paiement' => $_POST['type_paiement'] ?? 'Espèces',
                'id_facture' => (int) ($_POST['id_facture'] ?? 0),
            ];

            if ((new Paiement())->create($data)) {
                $_SESSION['success'] = 'Paiement enregistré avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l’enregistrement';
            }
            header('Location: /index.php?route=paiements');
            exit;
        }
    }
}
