<?php
ob_start();
$editMode = isset($livreur) && $livreur !== null;
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des livreurs</h2>
        <button class="btn" data-open-modal="livreur-modal">Ajouter un livreur</button>
    </div>
    <form class="search-bar" method="get">
        <input type="hidden" name="route" value="livreurs">
        <input type="text" name="search" placeholder="Rechercher un livreur" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="btn" type="submit">Rechercher</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Matricule</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livreurs as $livreurRow): ?>
                <tr>
                    <td><?= (int) $livreurRow['id_livreur'] ?></td>
                    <td><?= htmlspecialchars($livreurRow['nom']) ?></td>
                    <td><?= htmlspecialchars($livreurRow['prenom']) ?></td>
                    <td><?= htmlspecialchars($livreurRow['telephone']) ?></td>
                    <td><?= htmlspecialchars($livreurRow['matricule_moto']) ?></td>
                    <td>
                        <a class="btn small" href="/index.php?route=livreurs&id=<?= (int) $livreurRow['id_livreur'] ?>">Modifier</a>
                        <a class="btn danger small confirm-delete" href="/index.php?route=livreurs&action=delete&id=<?= (int) $livreurRow['id_livreur'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal" id="livreur-modal">
    <div class="modal-content">
        <h3><?= $editMode ? 'Modifier' : 'Ajouter' ?> un livreur</h3>
        <form method="post" action="/index.php?route=livreurs<?= $editMode ? '&id=' . (int) $livreur['id_livreur'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= $editMode ? htmlspecialchars($livreur['nom']) : '' ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= $editMode ? htmlspecialchars($livreur['prenom']) : '' ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= $editMode ? htmlspecialchars($livreur['telephone']) : '' ?>" required>
            <input type="text" name="matricule_moto" placeholder="Matricule moto" value="<?= $editMode ? htmlspecialchars($livreur['matricule_moto']) : '' ?>" required>
            <div class="modal-actions">
                <button class="btn" type="submit">Enregistrer</button>
                <button class="btn secondary" type="button" data-close-modal="livreur-modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Livreurs', $content);
