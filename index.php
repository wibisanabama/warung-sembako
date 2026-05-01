<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

// Fetch summary stats
$conn = getDB();

$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$low_stock = $conn->query("SELECT COUNT(*) as count FROM products WHERE stock < 10")->fetch_assoc()['count'];
$total_sales_today = $conn->query("SELECT SUM(total_amount) as total FROM transactions WHERE DATE(transaction_date) = CURDATE()")->fetch_assoc()['total'] ?? 0;

$recent_transactions = $conn->query("SELECT * FROM transactions ORDER BY transaction_date DESC LIMIT 5");
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Dashboard</h1>
            <p style="color: var(--text-muted)">Selamat datang di sistem manajemen Warung Sembako.</p>
        </div>
        <div class="user-profile">
            <div style="text-align: right">
                <p style="font-weight: 600">Admin Warung</p>
                <p style="font-size: 0.75rem; color: var(--text-muted)">Owner</p>
            </div>
            <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="stats-grid fade-in" style="animation-delay: 0.1s">
        <div class="card stat-card">
            <div class="stat-icon icon-blue">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>Total Produk</h3>
                <p><?= number_format($total_products) ?></p>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-icon icon-green">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Kategori</h3>
                <p><?= number_format($total_categories) ?></p>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-icon icon-red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>Stok Tipis</h3>
                <p><?= number_format($low_stock) ?></p>
            </div>
        </div>
        <div class="card stat-card">
            <div class="stat-icon icon-orange">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <h3>Penjualan Hari Ini</h3>
                <p>Rp <?= number_format($total_sales_today, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div class="card fade-in" style="animation-delay: 0.2s">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.25rem;">Transaksi Terbaru</h2>
            <a href="transactions.php" class="btn btn-primary" style="font-size: 0.875rem;">
                <i class="fas fa-plus"></i> Transaksi Baru
            </a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Waktu</th>
                        <th>Total Amount</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_transactions->num_rows > 0): ?>
                        <?php while($row = $recent_transactions->fetch_assoc()): ?>
                            <tr>
                                <td>#<?= str_pad($row['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['transaction_date'])) ?></td>
                                <td style="font-weight: 600;">Rp <?= number_format($row['total_amount'], 0, ',', '.') ?></td>
                                <td>
                                    <button class="btn" style="padding: 0.4rem; color: var(--primary)"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
