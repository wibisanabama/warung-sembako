<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

$conn = getDB();
$query = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = $conn->query($query);
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Riwayat Transaksi</h1>
            <p style="color: var(--text-muted)">Catatan penjualan warung Anda.</p>
        </div>
        <div>
            <a href="transaction-new.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>
        </div>
    </header>

    <div class="card fade-in" style="animation-delay: 0.1s">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal & Waktu</th>
                        <th>Total Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#TRX-<?= str_pad($row['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['transaction_date'])) ?></td>
                                <td style="font-weight: 600;">Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                                <td>
                                    <button class="btn" style="padding: 0.4rem; color: var(--primary)"><i class="fas fa-eye"></i> Detail</button>
                                    <button class="btn" style="padding: 0.4rem; color: var(--accent)"><i class="fas fa-print"></i> Cetak</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                <i class="fas fa-receipt" style="font-size: 3rem; opacity: 0.2; display: block; margin-bottom: 1rem;"></i>
                                Belum ada riwayat transaksi.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
