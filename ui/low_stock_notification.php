<?php
session_start();

// Include your database connection file
include 'conndb.php'; // Ensure this file sets up the $pdo object

try {
    // Query to get the low stock count
    $query = "SELECT COUNT(*) as lowStockCount FROM products WHERE stock < 10"; // Adjust the query as per your database schema
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $lowStockCount = $result['lowStockCount'] ?? 0;

    echo json_encode(['lowStockCount' => $lowStockCount]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>