<?php include __DIR__ . '/partials/layout.php'; ?>

<section class="content-header">
    <h1>Gestion des factures</h1>
</section>

<div class="table-card">
    <table>
        <thead>
            <tr><th>#</th><th>Date</th><th>Montant</th><th>Commande</th></tr>
        </thead>
        <tbody>
            <?php foreach ($factures as $facture): ?>
                <tr>
                    <td><?= (int)$facture['id_facture'] ?></td>
                    <td><?= htmlspecialchars($facture['date_facture']) ?></td>
                    <td><?= number_format((float)$facture['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= (int)$facture['id_commande'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/partials/layout-footer.php'; ?>
