<aside class="sidebar">
    <div class="logo">
        <i class="fas fa-store"></i>
        <span><b>Raissa</b></span>
    </div>
    
    <nav class="nav-links">
        <div class="nav-item">
            <a href="index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i>
                Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="products.php" class="nav-link <?= in_array(basename($_SERVER['PHP_SELF']), ['products.php', 'product-add.php', 'product-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-box"></i>
                Produk
            </a>
        </div>
        <div class="nav-item">
            <a href="transactions.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'transactions.php' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i>
                Transaksi
            </a>
        </div>
        <div class="nav-item">
            <a href="reports.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : '' ?>">
                <i class="fas fa-file-invoice-dollar"></i>
                Laporan
            </a>
        </div>
    </nav>
    

</aside>
