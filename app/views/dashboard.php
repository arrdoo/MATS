<?php
ob_start();
?>
<section class="hero-panel">
    <div>
        <p class="eyebrow">Vue d’ensemble</p>
        <h2>Gérez votre activité commerciale en un seul endroit</h2>
        <p>Ajoutez des clients, créez des commandes, suivez les paiements et visualisez le chiffre d’affaires en temps réel.</p>
    </div>
    <div class="hero-actions">
        <a class="btn" href="/index.php?route=clients">Ajouter un client</a>
        <a class="btn secondary" href="/index.php?route=commandes">Créer une commande</a>
    </div>
</section>

<section class="cards">
    <div class="card">
        <h3>Clients</h3>
        <p><?= $clientCount ?></p>
    </div>
    <div class="card">
        <h3>Commandes</h3>
        <p><?= $commandeCount ?></p>
    </div>
    <div class="card highlight">
        <h3>Chiffre d'affaires</h3>
        <p><?= number_format($revenue, 0, ',', ' ') ?> FCFA</p>
    </div>
    <div class="card">
        <h3>Produits</h3>
        <p><?= $produitCount ?></p>
    </div>
    <div class="card">
        <h3>Livreurs</h3>
        <p><?= $livreurCount ?></p>
    </div>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Dashboard', $content);
