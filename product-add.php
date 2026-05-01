<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

$conn = getDB();
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $unit = $conn->real_escape_string($_POST['unit']);
    
    $sql = "INSERT INTO products (name, category_id, price, stock, unit) 
            VALUES ('$name', $category_id, $price, $stock, '$unit')";
            
    if ($conn->query($sql)) {
        $message = "Produk berhasil ditambahkan!";
        $message_type = "success";
    } else {
        $message = "Gagal menambahkan produk: " . $conn->error;
        $message_type = "error";
    }
}
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Tambah Produk Baru</h1>
            <p style="color: var(--text-muted)">Isi formulir di bawah untuk menambah stok baru.</p>
        </div>
        <div>
            <a href="products.php" class="btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </header>

    <?php if ($message): ?>
        <div class="card fade-in" style="margin-bottom: 1.5rem; background: <?= $message_type == 'success' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $message_type == 'success' ? 'var(--secondary)' : 'var(--danger)' ?>; border: 1px solid <?= $message_type == 'success' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="card fade-in" style="max-width: 800px; animation-delay: 0.1s">
        <form action="" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Beras Pandan Wangi 5kg" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php while($cat = $categories->fetch_assoc()): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" class="form-control" placeholder="Contoh: kg, pcs, karung" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="number" name="price" class="form-control" placeholder="0" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stock" class="form-control" placeholder="0" required>
                </div>
            </div>
            
            <div style="margin-top: 1rem; text-align: right;">
                <button type="reset" class="btn" style="color: var(--text-muted)">Reset</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
