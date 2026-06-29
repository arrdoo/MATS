<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des produits</h1>
    <button class="btn btn-primary" onclick="openModal('produitModal')">Ajouter un produit</button>
</section>

<form class="search-bar" method="get">
    <input type="hidden" name="action" value="produits">
    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un produit...">
    <button type="submit" class="btn btn-secondary">Rechercher</button>
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>#</th><th>Nom</th><th>Prix unitaire</th><th>Stock</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= (int)$produit['id_produit'] ?></td>
                    <td><?= htmlspecialchars($produit['nom_produit']) ?></td>
                    <td><?= number_format((float)$produit['prix_unitaire'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= (int)$produit['quantite_stock'] ?></td>
                    <td>
                        <a class="btn btn-small" href="/index.php?action=produits&id=<?= (int)$produit['id_produit'] ?>">Modifier</a>
                        <a class="btn btn-danger btn-small confirm-delete" href="/index.php?action=produits&delete=1&id=<?= (int)$produit['id_produit'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="produitModal" class="modal">
    <div class="modal-content">
        <h3><?= isset($produit) ? 'Modifier le produit' : 'Ajouter un produit' ?></h3>
        <form method="post" action="/index.php?action=produits<?= isset($produit) ? '&id=' . (int)$produit['id_produit'] : '' ?>">
            <input type="text" name="nom_produit" placeholder="Nom du produit" value="<?= htmlspecialchars($produit['nom_produit'] ?? '') ?>" required>
            <input type="number" step="0.01" name="prix_unitaire" placeholder="Prix unitaire" value="<?= htmlspecialchars($produit['prix_unitaire'] ?? '') ?>" required>
            <input type="number" name="quantite_stock" placeholder="Quantité en stock" value="<?= htmlspecialchars($produit['quantite_stock'] ?? '') ?>" required>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('produitModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
