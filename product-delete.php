<?php 
require_once 'config/database.php';

if (isset($_GET['id'])) {
    $conn = getDB();
    $id = (int)$_GET['id'];
    
    // Check if product is linked to transactions
    $check = $conn->query("SELECT id FROM transaction_details WHERE product_id = $id LIMIT 1");
    
    if ($check->num_rows > 0) {
        // If linked, we might want to just "soft delete" or warn. 
        // For this simple project, we'll just show an error if we can't delete due to FK.
        // But our schema says ON DELETE SET NULL, so it should be fine.
    }
    
    if ($conn->query("DELETE FROM products WHERE id = $id")) {
        header("Location: products.php?msg=deleted");
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    header("Location: products.php");
}
?>
