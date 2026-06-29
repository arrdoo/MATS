<?php
session_start();

require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Client.php';
require_once __DIR__ . '/../app/models/Produit.php';
require_once __DIR__ . '/../app/models/Livreur.php';
require_once __DIR__ . '/../app/models/Commande.php';
require_once __DIR__ . '/../app/models/Facture.php';
require_once __DIR__ . '/../app/models/Paiement.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ClientController.php';
require_once __DIR__ . '/../app/controllers/ProduitController.php';
require_once __DIR__ . '/../app/controllers/LivreurController.php';
require_once __DIR__ . '/../app/controllers/CommandeController.php';
require_once __DIR__ . '/../app/controllers/FactureController.php';
require_once __DIR__ . '/../app/controllers/PaiementController.php';

$route = $_GET['route'] ?? 'dashboard';
$authController = new AuthController();

if ($route !== 'login' && $route !== 'logout') {
    if (empty($_SESSION['user'])) {
        header('Location: /index.php?route=login');
        exit;
    }
}

switch ($route) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'clients':
        $controller = new ClientController();
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $controller->delete();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['id'])) {
                $controller->edit();
            } else {
                $controller->create();
            }
        } elseif (isset($_GET['id'])) {
            $controller->edit();
        } else {
            $controller->index();
        }
        break;
    case 'produits':
        $controller = new ProduitController();
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $controller->delete();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['id'])) {
                $controller->edit();
            } else {
                $controller->create();
            }
        } elseif (isset($_GET['id'])) {
            $controller->edit();
        } else {
            $controller->index();
        }
        break;
    case 'livreurs':
        $controller = new LivreurController();
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $controller->delete();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['id'])) {
                $controller->edit();
            } else {
                $controller->create();
            }
        } elseif (isset($_GET['id'])) {
            $controller->edit();
        } else {
            $controller->index();
        }
        break;
    case 'commandes':
        $controller = new CommandeController();
        if (isset($_GET['action']) && $_GET['action'] === 'delete') {
            $controller->delete();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } else {
            $controller->index();
        }
        break;
    case 'factures':
        $controller = new FactureController();
        $controller->index();
        break;
    case 'paiements':
        $controller = new PaiementController();
        if (isset($_GET['action']) && $_GET['action'] === 'create') {
            $controller->create();
        } else {
            $controller->index();
        }
        break;
    case 'dashboard':
    default:
        $clientCount = (new Client())->count();
        $commandeCount = (new Commande())->count();
        $revenue = (new Commande())->revenue();
        $produitCount = (new Produit())->count();
        $livreurCount = (new Livreur())->count();
        include __DIR__ . '/../app/views/dashboard.php';
        break;
}
