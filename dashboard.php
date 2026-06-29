<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Tableau de bord</h1>
    <p>Vue d’ensemble de votre activité commerciale</p>
</section>

<section class="stats-grid">
    <div class="stat-card">
        <h3>Clients</h3>
        <p><?= (int)($clients[0]['total'] ?? 0) ?></p>
    </div>
    <div class="stat-card">
        <h3>Commandes</h3>
        <p><?= (int)($commandes[0]['total'] ?? 0) ?></p>
    </div>
    <div class="stat-card">
        <h3>Chiffre d'affaires</h3>
        <p><?= number_format((float)($ca['total'] ?? 0), 0, ',', ' ') ?> FCFA</p>
    </div>
    <div class="stat-card">
        <h3>Produits</h3>
        <p><?= (int)($produits[0]['total'] ?? 0) ?></p>
    </div>
    <div class="stat-card">
        <h3>Livreurs</h3>
        <p><?= (int)($livreurs[0]['total'] ?? 0) ?></p>
    </div>
</section>

<section class="table-card" style="margin-top: 1rem;">
    <h3>Bienvenue dans votre espace de gestion</h3>
    <p>Suivez vos clients, produits, commandes, livreurs et paiements depuis un seul tableau de bord moderne et rapide.</p>
</section>
