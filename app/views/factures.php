<?php
ob_start();
?>
<section class="panel">
    <div class="panel-header">
        <h2>Gestion des factures</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Date</th><th>Montant</th><th>Commande</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factures as $factureRow): ?>
                <tr>
                    <td><?= (int) $factureRow['id_facture'] ?></td>
                    <td><?= htmlspecialchars($factureRow['date_facture']) ?></td>
                    <td><?= number_format((float) $factureRow['montant'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= (int) $factureRow['id_commande'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
renderLayout('Factures', $content);
