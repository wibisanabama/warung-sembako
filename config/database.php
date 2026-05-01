<?php
/**
 * Database connection configuration
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'warung_sembako';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}

/**
 * Utility function to get connection
 */
function getDB() {
    global $conn;
    return $conn;
}
?>
