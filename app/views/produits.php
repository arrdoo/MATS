<?php
ob_start();
$editMode = isset($produit) && $produit !== null;
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des produits</h2>
        <button class="btn" data-open-modal="produit-modal">Ajouter un produit</button>
    </div>
    <form class="search-bar" method="get">
        <input type="hidden" name="route" value="produits">
        <input type="text" name="search" placeholder="Rechercher un produit" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn" type="submit">Rechercher</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nom</th><th>Prix unitaire</th><th>Stock</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $produitRow): ?>
                <tr>
                    <td><?= (int) $produitRow['id_produit'] ?></td>
                    <td><?= htmlspecialchars($produitRow['nom_produit']) ?></td>
                    <td><?= number_format((float) $produitRow['prix_unitaire'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= (int) $produitRow['quantite_stock'] ?></td>
                    <td>
                        <a class="btn small" href="/index.php?route=produits&id=<?= (int) $produitRow['id_produit'] ?>">Modifier</a>
                        <a class="btn danger small confirm-delete" href="/index.php?route=produits&action=delete&id=<?= (int) $produitRow['id_produit'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal" id="produit-modal">
    <div class="modal-content">
        <h3><?= $editMode ? 'Modifier' : 'Ajouter' ?> un produit</h3>
        <form method="post" action="/index.php?route=produits<?= $editMode ? '&id=' . (int) $produit['id_produit'] : '' ?>">
            <input type="text" name="nom_produit" placeholder="Nom du produit" value="<?= $editMode ? htmlspecialchars($produit['nom_produit']) : '' ?>" required>
            <input type="number" name="prix_unitaire" step="0.01" placeholder="Prix unitaire" value="<?= $editMode ? htmlspecialchars($produit['prix_unitaire']) : '' ?>" required>
            <input type="number" name="quantite_stock" placeholder="Quantité en stock" value="<?= $editMode ? htmlspecialchars($produit['quantite_stock']) : '' ?>" required>
            <div class="modal-actions">
                <button class="btn" type="submit">Enregistrer</button>
                <button class="btn secondary" type="button" data-close-modal="produit-modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Produits', $content);
