<?php
function renderLayout(string $title, string $content): void
{
    $successMessage = '';
    if (!empty($_SESSION['success'])) {
        $successMessage = '<div class="alert success">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }

    $errorMessage = '';
    if (!empty($_SESSION['error'])) {
        $errorMessage = '<div class="alert error">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }

    echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$title</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <h2>Gestion Commerciale</h2>
            <nav>
                <a href="/index.php?route=dashboard">Dashboard</a>
                <a href="/index.php?route=clients">Clients</a>
                <a href="/index.php?route=produits">Produits</a>
                <a href="/index.php?route=commandes">Commandes</a>
                <a href="/index.php?route=livreurs">Livreurs</a>
                <a href="/index.php?route=factures">Factures</a>
                <a href="/index.php?route=paiements">Paiements</a>
                <a href="/index.php?route=logout">Déconnexion</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <div>
                    <p class="eyebrow">Tableau de bord</p>
                    <h1>$title</h1>
                </div>
                <span class="admin-pill">Bienvenue administrateur</span>
            </header>
            $successMessage
            $errorMessage
            $content
        </main>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
HTML;
}
