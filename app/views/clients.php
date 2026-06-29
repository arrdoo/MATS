<?php
ob_start();
$editMode = isset($client) && $client !== null;
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des clients</h2>
        <button class="btn" data-open-modal="client-modal">Ajouter un client</button>
    </div>
    <form class="search-bar" method="get">
        <input type="hidden" name="route" value="clients">
        <input type="text" name="search" placeholder="Rechercher un client" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn" type="submit">Rechercher</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Adresse</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $clientRow): ?>
                <tr>
                    <td><?= (int) $clientRow['id_client'] ?></td>
                    <td><?= htmlspecialchars($clientRow['nom']) ?></td>
                    <td><?= htmlspecialchars($clientRow['prenom']) ?></td>
                    <td><?= htmlspecialchars($clientRow['telephone']) ?></td>
                    <td><?= htmlspecialchars($clientRow['adresse']) ?></td>
                    <td>
                        <a class="btn small" href="/index.php?route=clients&id=<?= (int) $clientRow['id_client'] ?>">Modifier</a>
                        <a class="btn danger small confirm-delete" href="/index.php?route=clients&action=delete&id=<?= (int) $clientRow['id_client'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal" id="client-modal">
    <div class="modal-content">
        <h3><?= $editMode ? 'Modifier' : 'Ajouter' ?> un client</h3>
        <form method="post" action="/index.php?route=clients<?= $editMode ? '&id=' . (int) $client['id_client'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= $editMode ? htmlspecialchars($client['nom']) : '' ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= $editMode ? htmlspecialchars($client['prenom']) : '' ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= $editMode ? htmlspecialchars($client['telephone']) : '' ?>" required>
            <input type="text" name="adresse" placeholder="Adresse" value="<?= $editMode ? htmlspecialchars($client['adresse']) : '' ?>" required>
            <div class="modal-actions">
                <button class="btn" type="submit">Enregistrer</button>
                <button class="btn secondary" type="button" data-close-modal="client-modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Clients', $content);
