<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des clients</h1>
    <button class="btn btn-primary" onclick="openModal('clientModal')">Ajouter un client</button>
</section>

<form class="search-bar" method="get">
    <input type="hidden" name="action" value="clients">
    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un client...">
    <button type="submit" class="btn btn-secondary">Rechercher</button>
</form>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>#</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Adresse</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= (int)$client['id_client'] ?></td>
                    <td><?= htmlspecialchars($client['nom']) ?></td>
                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                    <td><?= htmlspecialchars($client['telephone']) ?></td>
                    <td><?= htmlspecialchars($client['adresse']) ?></td>
                    <td>
                        <a class="btn btn-small" href="/index.php?action=clients&id=<?= (int)$client['id_client'] ?>">Modifier</a>
                        <a class="btn btn-danger btn-small confirm-delete" href="/index.php?action=clients&delete=1&id=<?= (int)$client['id_client'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="clientModal" class="modal">
    <div class="modal-content">
        <h3><?= isset($client) ? 'Modifier le client' : 'Ajouter un client' ?></h3>
        <form method="post" action="/index.php?action=clients<?= isset($client) ? '&id=' . (int)$client['id_client'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($client['nom'] ?? '') ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($client['prenom'] ?? '') ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= htmlspecialchars($client['telephone'] ?? '') ?>" required>
            <input type="text" name="adresse" placeholder="Adresse" value="<?= htmlspecialchars($client['adresse'] ?? '') ?>" required>
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('clientModal')">Annuler</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
