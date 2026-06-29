<?php
ob_start();
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des commandes</h2>
        <button class="btn" data-open-modal="commande-modal">Créer une commande</button>
    </div>
    <form class="search-bar" method="get">
        <input type="hidden" name="route" value="commandes">
        <input type="text" name="search" placeholder="Rechercher une commande" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn" type="submit">Rechercher</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Client</th><th>Livreur</th><th>Montant</th><th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commandeRow): ?>
                <tr>
                    <td><?= (int) $commandeRow['id_commande'] ?></td>
                    <td><?= htmlspecialchars($commandeRow['client_nom'] ?? '') ?> <?= htmlspecialchars($commandeRow['client_prenom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($commandeRow['livreur_nom'] ?? '') ?></td>
                    <td><?= number_format((float) $commandeRow['montant_total'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= htmlspecialchars($commandeRow['statut']) ?></td>
                    <td><a class="btn danger small confirm-delete" href="/index.php?route=commandes&action=delete&id=<?= (int) $commandeRow['id_commande'] ?>">Supprimer</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal" id="commande-modal">
    <div class="modal-content">
        <h3>Créer une commande</h3>
        <form method="post" action="/index.php?route=commandes">
            <select name="id_client" required>
                <option value="">Sélectionner un client</option>
                <?php foreach ($clients as $clientRow): ?>
                    <option value="<?= (int) $clientRow['id_client'] ?>"><?= htmlspecialchars($clientRow['nom'] . ' ' . $clientRow['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="id_livreur">
                <option value="0">Aucun livreur</option>
                <?php foreach ($livreurs as $livreurRow): ?>
                    <option value="<?= (int) $livreurRow['id_livreur'] ?>"><?= htmlspecialchars($livreurRow['nom'] . ' ' . $livreurRow['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="statut">
                <option>En attente</option>
                <option>En préparation</option>
                <option>En livraison</option>
                <option>Livrée</option>
                <option>Annulée</option>
            </select>
            <div id="produit-items">
                <div class="product-row">
                    <select name="produits[0][id]">
                        <?php foreach ($produits as $produitRow): ?>
                            <option value="<?= (int) $produitRow['id_produit'] ?>" data-price="<?= (float) $produitRow['prix_unitaire'] ?>"><?= htmlspecialchars($produitRow['nom_produit']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="produits[0][quantite]" value="1" min="1">
                </div>
            </div>
            <button class="btn secondary" type="button" id="add-product">Ajouter un produit</button>
            <input type="hidden" name="montant_total" id="montant_total" value="0">
            <div class="summary">Montant total : <span id="total-amount">0</span> FCFA</div>
            <div class="modal-actions">
                <button class="btn" type="submit">Créer</button>
                <button class="btn secondary" type="button" data-close-modal="commande-modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Commandes', $content);
