<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion du gérant</h1>
    <button class="btn btn-primary" onclick="openModal('gerantModal')">Ajouter un gérant</button>
</section>

<form class="search-bar" method="get">
    <input type="hidden" name="action" value="gerants">
    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un gérant...">
    <button type="submit" class="btn btn-secondary">Rechercher</button>
</form>

<div class="table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($gerants as $gerant): ?>
                <tr>
                    <td><?= (int)$gerant['id_gerant'] ?></td>
                    <td><?= htmlspecialchars($gerant['nom']) ?></td>
                    <td><?= htmlspecialchars($gerant['prenom']) ?></td>
                    <td><?= htmlspecialchars($gerant['telephone']) ?></td>
                    <td>
                        <a class="btn btn-small" href="/index.php?action=gerants&id=<?= (int)$gerant['id_gerant'] ?>">Modifier</a>
                        <a class="btn btn-danger btn-small confirm-delete" href="/index.php?action=gerants&delete=1&id=<?= (int)$gerant['id_gerant'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="gerantModal" class="modal">
    <div class="modal-content">
        <h3><?= isset($gerant) ? 'Modifier le gérant' : 'Ajouter un gérant' ?></h3>
        <form method="post" action="/index.php?action=gerants<?= isset($gerant) ? '&id=' . (int)$gerant['id_gerant'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($gerant['nom'] ?? '') ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($gerant['prenom'] ?? '') ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= htmlspecialchars($gerant['telephone'] ?? '') ?>" required>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('gerantModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
