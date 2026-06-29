<?php
class ProduitController
{
    private Produit $model;

    public function __construct()
    {
        $this->model = new Produit();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $produits = $this->model->all($search);
        include __DIR__ . '/../views/produits.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom_produit' => trim($_POST['nom_produit'] ?? ''),
                'prix_unitaire' => (float) ($_POST['prix_unitaire'] ?? 0),
                'quantite_stock' => (int) ($_POST['quantite_stock'] ?? 0),
            ];

            if ($this->model->create($data)) {
                $_SESSION['success'] = 'Produit ajouté avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l’ajout';
            }
            header('Location: /index.php?route=produits');
            exit;
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $produit = $this->model->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom_produit' => trim($_POST['nom_produit'] ?? ''),
                'prix_unitaire' => (float) ($_POST['prix_unitaire'] ?? 0),
                'quantite_stock' => (int) ($_POST['quantite_stock'] ?? 0),
            ];

            if ($this->model->update($id, $data)) {
                $_SESSION['success'] = 'Produit modifié avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la modification';
            }
            header('Location: /index.php?route=produits');
            exit;
        }

        include __DIR__ . '/../views/produits.php';
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Produit supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        header('Location: /index.php?route=produits');
        exit;
    }
}
