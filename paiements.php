<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des paiements</h1>
</section>

<div class="table-card">
    <h3>Enregistrer un paiement</h3>
    <form method="post" action="/index.php?action=paiements" class="form-grid">
        <select name="id_facture" required>
            <option value="">Sélectionner une facture</option>
            <?php foreach ($factures as $facture): ?>
                <option value="<?= (int)$facture['id_facture'] ?>">Facture #<?= (int)$facture['id_facture'] ?> - <?= number_format((float)$facture['montant'], 0, ',', ' ') ?> FCFA</option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="date_paiement" required>
        <input type="number" step="0.01" name="montant" placeholder="Montant" required>
        <select name="type_paiement" required>
            <option>Espèces</option><option>Carte bancaire</option><option>Wave</option><option>Orange Money</option><option>PayPal</option>
        </select>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Date</th><th>Montant</th><th>Type</th><th>Facture</th></tr>
        </thead>
        <tbody>
            <?php foreach ($paiements as $paiement): ?>
                <tr>
                    <td><?= (int)$paiement['id_paiement'] ?></td>
                    <td><?= htmlspecialchars($paiement['date_paiement']) ?></td>
                    <td><?= number_format((float)$paiement['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= htmlspecialchars($paiement['type_paiement']) ?></td>
                    <td><?= (int)$paiement['id_facture'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
