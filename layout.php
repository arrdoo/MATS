<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Commerciale</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <h2>Commerc'Pro</h2>
            <nav>
                <a href="/index.php?action=dashboard">Dashboard</a>
                <a href="/index.php?action=clients">Clients</a>
                <a href="/index.php?action=produits">Produits</a>
                <a href="/index.php?action=commandes">Commandes</a>
                <a href="/index.php?action=livreurs">Livreurs</a>
                <a href="/index.php?action=factures">Factures</a>
                <a href="/index.php?action=paiements">Paiements</a>
                <a href="/index.php?action=gerants">Gérant</a>
                <a href="/index.php?action=logout">Déconnexion</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <div>
                    <h3>Application de gestion commerciale</h3>
                    <p>Gestion complète de votre activité</p>
                </div>
                <div class="topbar-right">
                    <span>Connecté : <?= htmlspecialchars($_SESSION['user']['username'] ?? 'admin') ?></span>
                </div>
            </header>
            <section class="page-content">
