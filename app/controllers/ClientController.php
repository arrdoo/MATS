<?php
class ClientController
{
    private Client $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $clients = $this->model->all($search);
        include __DIR__ . '/../views/clients.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'adresse' => trim($_POST['adresse'] ?? ''),
            ];

            if ($this->model->create($data)) {
                $_SESSION['success'] = 'Client ajouté avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de l’ajout';
            }
            header('Location: /index.php?route=clients');
            exit;
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $client = $this->model->find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'adresse' => trim($_POST['adresse'] ?? ''),
            ];

            if ($this->model->update($id, $data)) {
                $_SESSION['success'] = 'Client modifié avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la modification';
            }
            header('Location: /index.php?route=clients');
            exit;
        }

        include __DIR__ . '/../views/clients.php';
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Client supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        header('Location: /index.php?route=clients');
        exit;
    }
}
