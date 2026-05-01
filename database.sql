-- Database initialization for Warung Sembako
CREATE DATABASE IF NOT EXISTS warung_sembako;
USE warung_sembako;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    unit VARCHAR(50) DEFAULT 'pcs',
    image VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Transactions table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL
);

-- Transaction Details table
CREATE TABLE IF NOT EXISTS transaction_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price_at_time DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Insert sample categories
INSERT INTO categories (name) VALUES ('Beras'), ('Minyak Goreng'), ('Gula'), ('Telur'), ('Mie Instan'), ('Minuman'), ('Sabun & Deterjen');

-- Insert sample products
INSERT INTO products (category_id, name, price, stock, unit) VALUES 
(1, 'Beras Pandan Wangi 5kg', 75000, 20, 'karung'),
(2, 'Minyak Goreng Bimoli 2L', 38000, 15, 'botol'),
(3, 'Gula Pasir Gulaku 1kg', 16000, 50, 'bungkus'),
(4, 'Telur Ayam Ras', 28000, 100, 'kg'),
(5, 'Indomie Goreng', 3000, 200, 'bungkus');
