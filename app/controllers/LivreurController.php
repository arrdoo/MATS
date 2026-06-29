<?php
class LivreurController
{
    private Livreur $model;

    public function __construct()
    {
        $this->model = new Livreur();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $livreurs = $this->model->all($search);
        include __DIR__ . '/../views/livreurs.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'matricule_moto' => trim($_POST['matricule_moto'] ?? ''),
            ];

            if ($this->model->create($data)) {
                $_SESSION['success'] = 'Livreur ajouté avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l’ajout';
            }
            header('Location: /index.php?route=livreurs');
            exit;
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $livreur = $this->model->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'matricule_moto' => trim($_POST['matricule_moto'] ?? ''),
            ];

            if ($this->model->update($id, $data)) {
                $_SESSION['success'] = 'Livreur modifié avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la modification';
            }
            header('Location: /index.php?route=livreurs');
            exit;
        }

        include __DIR__ . '/../views/livreurs.php';
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Livreur supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        header('Location: /index.php?route=livreurs');
        exit;
    }
}
