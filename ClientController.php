<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Client.php';

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
        $clients = $this->model->getAll($search);
        require __DIR__ . '/../views/clients.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: /index.php?action=clients');
            exit;
        }
    }

    public function update(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header('Location: /index.php?action=clients');
            exit;
        }

        $client = $this->model->getById($id);
        require __DIR__ . '/../views/clients.php';
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->model->delete($id);
        header('Location: /index.php?action=clients');
        exit;
    }
}
