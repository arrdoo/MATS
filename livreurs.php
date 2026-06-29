<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des livreurs</h1>
    <button class="btn btn-primary" onclick="openModal('livreurModal')">Ajouter un livreur</button>
</section>

<form class="search-bar" method="get">
    <input type="hidden" name="action" value="livreurs">
    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un livreur...">
    <button type="submit" class="btn btn-secondary">Rechercher</button>
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>#</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Immatriculation</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livreurs as $livreur): ?>
                <tr>
                    <td><?= (int)$livreur['id_livreur'] ?></td>
                    <td><?= htmlspecialchars($livreur['nom']) ?></td>
                    <td><?= htmlspecialchars($livreur['prenom']) ?></td>
                    <td><?= htmlspecialchars($livreur['telephone']) ?></td>
                    <td><?= htmlspecialchars($livreur['matricule_moto']) ?></td>
                    <td>
                        <a class="btn btn-small" href="/index.php?action=livreurs&id=<?= (int)$livreur['id_livreur'] ?>">Modifier</a>
                        <a class="btn btn-danger btn-small confirm-delete" href="/index.php?action=livreurs&delete=1&id=<?= (int)$livreur['id_livreur'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="livreurModal" class="modal">
    <div class="modal-content">
        <h3><?= isset($livreur) ? 'Modifier le livreur' : 'Ajouter un livreur' ?></h3>
        <form method="post" action="/index.php?action=livreurs<?= isset($livreur) ? '&id=' . (int)$livreur['id_livreur'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($livreur['nom'] ?? '') ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($livreur['prenom'] ?? '') ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= htmlspecialchars($livreur['telephone'] ?? '') ?>" required>
            <input type="text" name="matricule_moto" placeholder="Matricule moto" value="<?= htmlspecialchars($livreur['matricule_moto'] ?? '') ?>" required>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('livreurModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
