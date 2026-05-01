<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

$conn = getDB();

// Total Revenue
$revenue = $conn->query("SELECT SUM(total_amount) as total FROM transactions")->fetch_assoc()['total'] ?? 0;

// Sales by Category
$cat_sales = $conn->query("
    SELECT c.name, SUM(td.subtotal) as total 
    FROM categories c 
    JOIN products p ON c.id = p.category_id 
    JOIN transaction_details td ON p.id = td.product_id 
    GROUP BY c.id
");

// Top Products
$top_products = $conn->query("
    SELECT p.name, SUM(td.quantity) as sold 
    FROM products p 
    JOIN transaction_details td ON p.id = td.product_id 
    GROUP BY p.id 
    ORDER BY sold DESC 
    LIMIT 5
");
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Laporan Keuangan</h1>
            <p style="color: var(--text-muted)">Analisis performa penjualan warung Anda.</p>
        </div>
    </header>

    <div class="stats-grid fade-in" style="animation-delay: 0.1s">
        <div class="card stat-card" style="grid-column: span 2;">
            <div class="stat-icon icon-green">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-info">
                <h3>Total Pendapatan Keseluruhan</h3>
                <p style="font-size: 2rem;">Rp <?= number_format($revenue, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="fade-in" style="animation-delay: 0.2s">
        <div class="card">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Penjualan per Kategori</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Total Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $cat_sales->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td style="font-weight: 600;">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Produk Terlaris</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $top_products->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td style="font-weight: 600;"><?= $row['sold'] ?> Unit</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
