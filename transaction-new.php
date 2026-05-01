<?php 
require_once 'includes/header.php'; 
require_once 'includes/sidebar.php';

$conn = getDB();
$products = $conn->query("SELECT * FROM products WHERE stock > 0 ORDER BY name ASC");

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    // Get product info
    $p_res = $conn->query("SELECT * FROM products WHERE id = $product_id");
    if ($p_res->num_rows > 0) {
        $product = $p_res->fetch_assoc();
        
        if ($product['stock'] >= $quantity) {
            $total_amount = $product['price'] * $quantity;
            
            // Start transaction
            $conn->begin_transaction();
            
            try {
                // Insert transaction
                $conn->query("INSERT INTO transactions (total_amount) VALUES ($total_amount)");
                $transaction_id = $conn->insert_id;
                
                // Insert details
                $conn->query("INSERT INTO transaction_details (transaction_id, product_id, quantity, price_at_time, subtotal) 
                             VALUES ($transaction_id, $product_id, $quantity, {$product['price']}, $total_amount)");
                
                // Update stock
                $conn->query("UPDATE products SET stock = stock - $quantity WHERE id = $product_id");
                
                $conn->commit();
                $message = "Transaksi berhasil disimpan! Total: Rp " . number_format($total_amount, 0, ',', '.');
                $message_type = "success";
            } catch (Exception $e) {
                $conn->rollback();
                $message = "Gagal memproses transaksi: " . $e->getMessage();
                $message_type = "error";
            }
        } else {
            $message = "Stok tidak mencukupi!";
            $message_type = "error";
        }
    }
}
?>

<main class="main-container">
    <header class="fade-in">
        <div>
            <h1>Transaksi Baru</h1>
            <p style="color: var(--text-muted)">Catat penjualan produk ke pelanggan.</p>
        </div>
        <div>
            <a href="transactions.php" class="btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </header>

    <?php if ($message): ?>
        <div class="card fade-in" style="margin-bottom: 1.5rem; background: <?= $message_type == 'success' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $message_type == 'success' ? 'var(--secondary)' : 'var(--danger)' ?>; border: 1px solid <?= $message_type == 'success' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="card fade-in" style="animation-delay: 0.1s">
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Pilih Produk</label>
                <select name="product_id" id="product_id" class="form-control" required onchange="updatePrice()">
                    <option value="">-- Pilih Produk --</option>
                    <?php while($p = $products->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-stock="<?= $p['stock'] ?>">
                            <?= htmlspecialchars($p['name']) ?> (Stok: <?= $p['stock'] ?> <?= $p['unit'] ?>) - Rp <?= number_format($p['price'], 0, ',', '.') ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Jumlah (Qty)</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required oninput="updatePrice()">
            </div>
            
            <div class="card" style="background: rgba(99, 102, 241, 0.05); border: 1px dashed var(--primary); margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 500;">Total Bayar:</span>
                    <span id="total-display" style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">Rp 0</span>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem;">
                <i class="fas fa-check-circle"></i> Selesaikan Transaksi
            </button>
        </form>
    </div>
</main>

<script>
function updatePrice() {
    const select = document.getElementById('product_id');
    const quantity = document.getElementById('quantity').value;
    const totalDisplay = document.getElementById('total-display');
    
    const selectedOption = select.options[select.selectedIndex];
    if (selectedOption.value) {
        const price = selectedOption.getAttribute('data-price');
        const total = price * quantity;
        totalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    } else {
        totalDisplay.textContent = 'Rp 0';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
