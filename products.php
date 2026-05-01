<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

$conn = getDB();
$query = "SELECT p.*, c.name as category_name FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          ORDER BY p.name ASC";
$result = $conn->query($query);
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Daftar Produk</h1>
            <p style="color: var(--text-muted)">Kelola stok dan harga sembako Anda.</p>
        </div>
        <div>
            <a href="product-add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </header>

    <div class="card fade-in" style="animation-delay: 0.1s">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($row['name']) ?></td>
                            <td><span class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary)"><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized') ?></span></td>
                            <td style="font-weight: 600;">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td><?= $row['stock'] ?></td>
                            <td><?= htmlspecialchars($row['unit']) ?></td>
                            <td>
                                <?php if ($row['stock'] <= 5): ?>
                                    <span class="badge badge-low">Stok Rendah</span>
                                <?php else: ?>
                                    <span class="badge badge-safe">Aman</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="product-edit.php?id=<?= $row['id'] ?>" class="btn" style="padding: 0.4rem; color: var(--accent)"><i class="fas fa-edit"></i></a>
                                    <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn" style="padding: 0.4rem; color: var(--danger)"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        window.location.href = 'product-delete.php?id=' + id;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
