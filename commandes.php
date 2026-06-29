<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des commandes</h1>
</section>

<div class="table-card">
    <h3>Créer une commande</h3>
    <form id="orderForm" method="post" action="/index.php?action=commandes">
        <div class="form-grid">
            <select name="id_client" required>
                <option value="">Sélectionner un client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= (int)$client['id_client'] ?>"><?= htmlspecialchars($client['nom'] . ' ' . $client['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="id_livreur">
                <option value="">Sélectionner un livreur</option>
                <?php foreach ($livreurs as $livreur): ?>
                    <option value="<?= (int)$livreur['id_livreur'] ?>"><?= htmlspecialchars($livreur['nom'] . ' ' . $livreur['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="statut">
                <option>En attente</option><option>En préparation</option><option>En livraison</option><option>Livrée</option><option>Annulée</option>
            </select>
        </div>

        <div class="form-grid">
            <select id="productSelect">
                <option value="">Sélectionner un produit</option>
                <?php foreach ($produits as $produit): ?>
                    <option value="<?= (int)$produit['id_produit'] ?>" data-name="<?= htmlspecialchars($produit['nom_produit']) ?>" data-price="<?= (float)$produit['prix_unitaire'] ?>"><?= htmlspecialchars($produit['nom_produit']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" id="quantityInput" value="1" min="1">
            <button type="button" class="btn btn-secondary" onclick="addProductToOrder()">Ajouter produit</button>
        </div>

        <div id="orderItems" class="order-items"></div>
        <input type="hidden" name="products" id="productsInput" value="[]">
        <input type="hidden" name="montant_total" id="totalInput" value="0">
        <div class="summary">
            <strong>Total : <span id="orderTotal">0</span> FCFA</strong>
        </div>
        <button type="submit" class="btn btn-primary">Créer commande</button>
    </form>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Client</th><th>Livreur</th><th>Montant</th><th>Statut</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= (int)$commande['id_commande'] ?></td>
                    <td><?= htmlspecialchars(($commande['client_nom'] ?? '') . ' ' . ($commande['client_prenom'] ?? '')) ?></td>
                    <td><?= htmlspecialchars($commande['livreur_nom'] ?? '') ?></td>
                    <td><?= number_format((float)$commande['montant_total'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= htmlspecialchars($commande['statut']) ?></td>
                    <td>
                        <a class="btn btn-small" href="/index.php?action=factures&order_id=<?= (int)$commande['id_commande'] ?>&amount=<?= (float)$commande['montant_total'] ?>">Générer facture</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
