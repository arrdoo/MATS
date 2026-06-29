<?php
ob_start();
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des paiements</h2>
        <button class="btn" data-open-modal="paiement-modal">Enregistrer un paiement</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Date</th><th>Montant</th><th>Type</th><th>Facture</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paiements as $paiementRow): ?>
                <tr>
                    <td><?= (int) $paiementRow['id_paiement'] ?></td>
                    <td><?= htmlspecialchars($paiementRow['date_paiement']) ?></td>
                    <td><?= number_format((float) $paiementRow['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= htmlspecialchars($paiementRow['type_paiement']) ?></td>
                    <td><?= (int) $paiementRow['id_facture'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal" id="paiement-modal">
    <div class="modal-content">
        <h3>Enregistrer un paiement</h3>
        <form method="post" action="/index.php?route=paiements&action=create">
            <input type="date" name="date_paiement" value="<?= date('Y-m-d') ?>" required>
            <input type="number" name="montant" step="0.01" placeholder="Montant" required>
            <select name="type_paiement">
                <option>Espèces</option><option>Carte bancaire</option><option>Wave</option><option>Orange Money</option><option>PayPal</option>
            </select>
            <input type="number" name="id_facture" placeholder="ID Facture" required>
            <div class="modal-actions">
                <button class="btn" type="submit">Enregistrer</button>
                <button class="btn secondary" type="button" data-close-modal="paiement-modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Paiements', $content);
